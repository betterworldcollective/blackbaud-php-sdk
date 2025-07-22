<?php

namespace Blackbaud;

use Blackbaud\Authentications\BlackbaudOAuth;
use Blackbaud\Authentications\BlackbaudToken;
use Blackbaud\Data\Constituent\Constituent;
use Blackbaud\Data\Event\Event;
use Blackbaud\Data\Gift\Gift;
use Blackbaud\Enums\Resource;
use Blackbaud\Exceptions\InvalidDataException;
use Blackbaud\Resources\ConstituentCustomFieldCategoryDetailResource;
use Blackbaud\Resources\ConstituentCustomFieldResource;
use Blackbaud\Resources\ConstituentResource;
use Blackbaud\Resources\EventResource;
use Blackbaud\Resources\FundResource;
use Blackbaud\Resources\GiftResource;
use Blackbaud\Resources\QueryResource;
use Blackbaud\Responses\BlackbaudResponse;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\Connector;
use Saloon\Http\Response;

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
     * @throws FatalRequestException
     * @throws RequestException
     */
    public function create(Resource $resource, array $properties): int
    {
        return $this->resource($resource)->create($properties);
    }

    /**
     * @throws FatalRequestException
     * @throws RequestException
     * @throws InvalidDataException
     */
    public function get(Resource $resource, int $id): Gift|Event|Constituent
    {
        return $this->resource($resource)->get($id);
    }

    /**
     * @param  array<string, mixed>  $properties
     *
     * @throws FatalRequestException
     * @throws RequestException
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
}
