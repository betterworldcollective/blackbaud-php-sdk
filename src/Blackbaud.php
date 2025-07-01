<?php

namespace Blackbaud;

use Blackbaud\Authentications\BlackbaudOAuth;
use Blackbaud\Authentications\BlackbaudToken;
use Blackbaud\Resources\ConstituentResource;
use Blackbaud\Resources\EventResource;
use Blackbaud\Resources\GiftResource;
use Blackbaud\Resources\QueryResource;
use Blackbaud\Responses\BlackbaudResponse;
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
}
