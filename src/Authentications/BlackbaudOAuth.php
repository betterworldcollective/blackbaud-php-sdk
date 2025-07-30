<?php

namespace Blackbaud\Authentications;

use Blackbaud\Blackbaud;
use DateTimeImmutable;
use Saloon\Contracts\OAuthAuthenticator;
use Saloon\Exceptions\InvalidStateException;
use Saloon\Helpers\OAuth2\OAuthConfig;
use Saloon\Http\Auth\AccessTokenAuthenticator;
use Saloon\Traits\OAuth2\AuthorizationCodeGrant;

class BlackbaudOAuth extends Blackbaud
{
    use AuthorizationCodeGrant;

    public function __construct(
        string $clientId,
        string $clientSecret,
        string $redirectUri,
        string $subscriptionKey,
    ) {
        $this->oauthConfig()
            ->setClientId($clientId)
            ->setClientSecret($clientSecret)
            ->setRedirectUri($redirectUri);

        parent::__construct($subscriptionKey);
    }

    protected function defaultOauthConfig(): OAuthConfig
    {
        return OAuthConfig::make()
            ->setTokenEndpoint('https://oauth2.sky.blackbaud.com/token')
            ->setAuthorizeEndpoint('https://app.blackbaud.com/oauth/authorize');
    }

    public static function getAuthUrl(string $clientId, string $clientSecret, string $redirectUri): string
    {
        return (new self($clientId, $clientSecret, $redirectUri, ''))->getAuthorizationUrl();
    }

    /**
     * @throws \Blackbaud\Exceptions\InvalidStateException
     */
    public function requestAccessToken(string $code, ?string $state = null): OAuthAuthenticator
    {
        try {
            return $this->getAccessToken($code, $state);
        } catch (InvalidStateException $e) {
            throw new \Blackbaud\Exceptions\InvalidStateException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function requestAccessTokenWithRefreshToken(string $refreshToken): OAuthAuthenticator
    {
        return $this->refreshAccessToken($refreshToken);
    }

    public function authenticateWithToken(string $token, ?string $refreshToken = null, ?DateTimeImmutable $expiresAt = null): self
    {
        $authenticator = new AccessTokenAuthenticator(
            $token,
            $refreshToken,
            $expiresAt,
        );

        return $this->authenticate($authenticator);
    }
}
