<?php

use Blackbaud\Blackbaud;
use Blackbaud\Data\Gift\Gift;
use Blackbaud\Enums\GiftPaymentMethod;
use Blackbaud\Enums\GiftStatus;
use Blackbaud\Enums\GiftType;
use Blackbaud\Requests\Gift\EditRecurringGiftStatus;
use Saloon\Enums\Method;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

$client = Blackbaud::oauth('client-id', 'client-secret', 'redirect-url', 'subscription-key');

it('can retrieve gift information', function () use ($client): void {
    $gift = $client->gift()->get(280);

    expect($gift)->toBeInstanceOf(Gift::class)->and($gift->id)->toBe('1140');
});

it('can create gift information', function () use ($client): void {
    $newlyCreatedId = $client->gift()->create([
        'amount' => [
            'value' => 100,
        ],
        'constituent_id' => 593638,
        'gift_splits' => [
            [
                'fund_id' => 18,
                'amount' => [
                    'value' => 100,
                ],
            ],
        ],
        'payments' => [
            [
                'payment_method' => GiftPaymentMethod::Cash,
            ],
        ],
        'type' => GiftType::Donation,
    ]);

    expect($newlyCreatedId)->toBe(4442);
});

it('can update gift information', function () use ($client): void {
    expect($client->gift()->update(123, [
        'gift_code' => 'TestGiftCode',
    ]))->toBeTrue();
});

it('edits recurring gift status through the dedicated endpoint', function (): void {
    $mockClient = MockClient::global();
    $mockClient->addResponse(MockResponse::make([], 204), EditRecurringGiftStatus::class);
    $client = Blackbaud::oauth('client-id', 'client-secret', 'redirect-url', 'subscription-key');

    expect($client->gift()->editRecurringGiftStatus(9876, GiftStatus::Held))->toBeTrue();

    $mockClient->assertSent(function ($request): bool {
        return $request instanceof EditRecurringGiftStatus
            && $request->getMethod() === Method::PUT
            && $request->resolveEndpoint() === '/gift/v1/recurringgifts/9876/status'
            && $request->defaultBody() === ['gift_status' => 'Held'];
    });
});

it('throws on a failed recurring gift status edit', function (): void {
    MockClient::global()->addResponse(MockResponse::make(['error' => 'invalid status'], 422), EditRecurringGiftStatus::class);
    $client = Blackbaud::oauth('client-id', 'client-secret', 'redirect-url', 'subscription-key');

    expect(fn () => $client->gift()->editRecurringGiftStatus(9876, GiftStatus::Active))
        ->toThrow(RequestException::class);
});
