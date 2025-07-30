<?php

namespace Blackbaud;

use Blackbaud\Authentications\BlackbaudOAuth;
use Blackbaud\Authentications\BlackbaudToken;
use Blackbaud\Data\Constituent\Constituent;
use Blackbaud\Data\Event\Event;
use Blackbaud\Data\Gift\Gift;
use Blackbaud\Enums\Resource;
use Blackbaud\Exceptions\BadRequestException;
use Blackbaud\Exceptions\InvalidDataException;
use Blackbaud\Exceptions\ObjectNotFoundException;
use Blackbaud\Exceptions\UnauthorizedException;
use Blackbaud\Resources\ConstituentCustomFieldCategoryDetailResource;
use Blackbaud\Resources\ConstituentCustomFieldResource;
use Blackbaud\Resources\ConstituentResource;
use Blackbaud\Resources\EventResource;
use Blackbaud\Resources\FundResource;
use Blackbaud\Resources\GiftCustomFieldCategoryDetailResource;
use Blackbaud\Resources\GiftCustomFieldResource;
use Blackbaud\Resources\GiftResource;
use Blackbaud\Resources\QueryResource;
use Blackbaud\Responses\BlackbaudResponse;
use DateTimeImmutable;
use Saloon\Http\Auth\AccessTokenAuthenticator;
use Saloon\Http\Connector;
use Saloon\Http\Response;
use Throwable;

abstract class Blackbaud extends Connector
{
    /**
     * Define the custom response
     *
     * @var class-string<Response>|null
     */
    protected ?string $response = BlackbaudResponse::class;

    public function __construct(string $subscriptionKey)
    {
        $this->headers()->add('Bb-Api-Subscription-Key', $subscriptionKey);
    }

    public static function oauth(string $clientId, string $clientSecret, string $redirectUri, string $subscriptionKey): BlackbaudOAuth
    {
        return new BlackbaudOAuth($clientId, $clientSecret, $redirectUri, $subscriptionKey);
    }

    public static function token(string $token, string $subscriptionKey): BlackbaudToken
    {
        return new BlackbaudToken($token, $subscriptionKey);
    }

    /**
     * Resolve the base URL of the service.
     */
    public function resolveBaseUrl(): string
    {
        return 'https://api.sky.blackbaud.com';
    }

    /**
     * Define default headers
     *
     * @return string[]
     */
    protected function defaultHeaders(): array
    {
        return [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];
    }

    public function constituent(): ConstituentResource
    {
        return new ConstituentResource($this);
    }

    public function constituentCustomField(): ConstituentCustomFieldResource
    {
        return new ConstituentCustomFieldResource($this);
    }

    public function constituentCustomFieldCategoryDetail(): ConstituentCustomFieldCategoryDetailResource
    {
        return new ConstituentCustomFieldCategoryDetailResource($this);
    }

    public function gift(): GiftResource
    {
        return new GiftResource($this);
    }

    public function giftCustomField(): GiftCustomFieldResource
    {
        return new GiftCustomFieldResource($this);
    }

    public function giftCustomFieldCategoryDetail(): GiftCustomFieldCategoryDetailResource
    {
        return new GiftCustomFieldCategoryDetailResource($this);
    }

    public function event(): EventResource
    {
        return new EventResource($this);
    }

    public function tableQuery(): QueryResource
    {
        return new QueryResource($this);
    }

    public function fund(): FundResource
    {
        return new FundResource($this);
    }

    /**
     * @param  array<string, mixed>  $properties
     *
     * @throws BadRequestException
     * @throws UnauthorizedException
     */
    public function create(Resource $resource, array $properties): int
    {
        return $this->resource($resource)->create($properties);
    }

    /**
     * @throws ObjectNotFoundException
     * @throws UnauthorizedException
     * @throws InvalidDataException
     */
    public function get(Resource $resource, int $id): Gift|Event|Constituent
    {
        return $this->resource($resource)->get($id);
    }

    /**
     * @param  array<string, mixed>  $properties
     *
     * @throws BadRequestException
     * @throws UnauthorizedException
     */
    public function update(Resource $resource, int $id, array $properties): true
    {
        return $this->resource($resource)->update($id, $properties);
    }

    public function resource(Resource $resource): ConstituentResource|GiftResource|EventResource
    {
        return match ($resource) {
            Resource::Constituent => $this->constituent(),
            Resource::Gift => $this->gift(),
            Resource::Event => $this->event(),
        };
    }

    public function getRequestException(Response $response, ?Throwable $senderException): ?Throwable
    {
        return match ($response->status()) {
            401 => new UnauthorizedException($response->json()['message']),
            404 => new ObjectNotFoundException,
            400 => new BadRequestException($response->json()),
            default => $senderException,
        };
    }

    public function authenticateWithToken(string $token, ?string $refreshToken = null, ?DateTimeImmutable $expiresAt = null): static
    {
        $authenticator = new AccessTokenAuthenticator(
            $token,
            $refreshToken,
            $expiresAt,
        );

        return $this->authenticate($authenticator);
    }
}
