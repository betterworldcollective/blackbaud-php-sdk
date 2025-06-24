<?php

namespace Blackbaud\Authentications;

use Blackbaud\Blackbaud;
use Saloon\Helpers\OAuth2\OAuthConfig;
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
}
