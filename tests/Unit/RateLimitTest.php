<?php

use Blackbaud\Blackbaud;
use Blackbaud\Exceptions\QuotaExceededException;
use Blackbaud\Exceptions\UnauthorizedException;
use Blackbaud\Requests\Gift\CreateGiftCustomField;
use Blackbaud\Responses\BlackbaudResponse;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Response as PsrResponse;
use Saloon\Exceptions\Request\Statuses\ForbiddenException;
use Saloon\Exceptions\Request\Statuses\TooManyRequestsException;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

$client = Blackbaud::token('token', 'subscription-key');

/**
 * Rebuilds what Saloon hands to the connector in production: the Guzzle sender throws on a failed
 * status (http_errors is on), so the mapper always receives a sender exception alongside the response.
 *
 * @param  array<string, string>  $headers
 * @return array{BlackbaudResponse, ClientException}
 */
function throttledResponse(int $status, array $headers = [], string $body = '{"message":"Rate limit is exceeded. Try again in 1 seconds."}'): array
{
    $request = new CreateGiftCustomField(['category' => 'Favorite Color']);

    $pendingRequest = Blackbaud::token('token', 'subscription-key')->createPendingRequest(
        $request,
        new MockClient([CreateGiftCustomField::class => MockResponse::make([], $status, $headers)]),
    );

    $psrRequest = $pendingRequest->createPsrRequest();
    $psrResponse = new PsrResponse($status, $headers, $body);

    $senderException = new ClientException('Client error', $psrRequest, $psrResponse);

    return [
        BlackbaudResponse::fromPsrResponse($psrResponse, $pendingRequest, $psrRequest, $senderException),
        $senderException,
    ];
}

it('maps a 429 to the Saloon rate limit exception', function () use ($client): void {
    [$response, $senderException] = throttledResponse(429, ['Retry-After' => '1']);

    $exception = $client->getRequestException($response, $senderException);

    expect($exception)->toBeInstanceOf(TooManyRequestsException::class)
        ->and($exception->getResponse()->header('Retry-After'))->toBe('1')
        ->and($exception->getPrevious())->toBe($senderException);
});

it('maps a 429 without a Retry-After header to the Saloon rate limit exception', function () use ($client): void {
    [$response, $senderException] = throttledResponse(429);

    expect($client->getRequestException($response, $senderException))
        ->toBeInstanceOf(TooManyRequestsException::class);
});

it('maps a 403 carrying a Retry-After header to a quota exception callers retry the same way', function () use ($client): void {
    [$response, $senderException] = throttledResponse(403, ['Retry-After' => '3600'], '{"message":"Daily quota exceeded."}');

    $exception = $client->getRequestException($response, $senderException);

    expect($exception)->toBeInstanceOf(QuotaExceededException::class)
        ->and($exception)->toBeInstanceOf(TooManyRequestsException::class)
        ->and($exception->getResponse()->header('Retry-After'))->toBe('3600');
});

it('leaves a 403 without a Retry-After header alone', function () use ($client): void {
    [$response, $senderException] = throttledResponse(403, body: '{"message":"Forbidden."}');

    expect($client->getRequestException($response, $senderException))->toBe($senderException);
});

it('still maps a 401 to the unauthorized exception', function () use ($client): void {
    [$response, $senderException] = throttledResponse(401, ['Retry-After' => '1'], '{"message":"Access denied."}');

    expect($client->getRequestException($response, $senderException))
        ->toBeInstanceOf(UnauthorizedException::class);
});

it('throws the quota exception through a sent request', function (): void {
    $client = Blackbaud::token('token', 'subscription-key')
        ->withMockClient(new MockClient([
            CreateGiftCustomField::class => MockResponse::make(
                ['message' => 'Daily quota exceeded.'],
                403,
                ['Retry-After' => '3600'],
            ),
        ]));

    expect(fn () => $client->giftCustomField()->create(['category' => 'Favorite Color', 'value' => 'Blue']))
        ->toThrow(QuotaExceededException::class);
});

it('leaves a sent 403 without a Retry-After header as a forbidden error', function (): void {
    $client = Blackbaud::token('token', 'subscription-key')
        ->withMockClient(new MockClient([
            CreateGiftCustomField::class => MockResponse::make(['message' => 'Forbidden.'], 403),
        ]));

    expect(fn () => $client->giftCustomField()->create(['category' => 'Favorite Color', 'value' => 'Blue']))
        ->toThrow(ForbiddenException::class);
});
