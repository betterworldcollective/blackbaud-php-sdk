<?php

namespace Blackbaud\Authentications;

use Blackbaud\Blackbaud;
use Saloon\Http\Auth\TokenAuthenticator;
use Saloon\Traits\OAuth2\AuthorizationCodeGrant;

class BlackbaudToken extends Blackbaud
{
    use AuthorizationCodeGrant;

    public function __construct(protected readonly string $token, string $subscriptionKey)
    {
        parent::__construct($subscriptionKey);
    }

    protected function defaultAuth(): TokenAuthenticator
    {
        return new TokenAuthenticator($this->token);
    }
}
