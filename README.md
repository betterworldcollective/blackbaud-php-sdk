# Blackbaud PHP SDK

A work-in-progress PHP Blackbaud API SDK powered by [Saloon](https://github.com/saloonphp/saloon).


## Installation

```bash
composer require betterworldcollective/blackbaud-php-sdk
```

## Authentication

Blackbaud uses OAuth 2.0 for authenticating access to Blackbaud SkyAPI. Here's how to set up and use the authentication flow using the SDK:

To begin the OAuth flow, you'll need to redirect your user to an authorization URL where they can grant your application access.
```php
use Blackbaud\Authentications\BlackbaudOAuth;

$clientId = 'YOUR_BLACKBAUD_CLIENT_ID';
$clientSecret = 'YOUR_BLACKBAUD_SECRET_KEY';
$callbackUrl = 'https://app-callback-url/auth/callback';

// Generate the Blackbaud OAuth login URL
$authUrl = BlackbaudOAuth::getAuthUrl($clientId, $clientSecret, $callbackUrl);
```

After successful login, Blackbaud will redirect the user back to your callback URL with a code and state which we can use to exchange for an access token.
```php
use Blackbaud\Blackbaud;

$clientId = 'YOUR_BLACKBAUD_CLIENT_ID';
$clientSecret = 'YOUR_BLACKBAUD_SECRET_KEY';
$callbackUrl = 'https://app-callback-url/auth/callback';
$subscriptionKey = 'YOUR_BLACKBAUD_SUBSCRIPTION_KEY';

// Initialize client
$client = Blackbaud::oauth($clientId, $clientSecret, $callbackUrl, $subscriptionKey);

// Retrieve the access token using the code and state returned from the OAuth login
$access = $client->getAccessToken($code, $state);

// Authenticate the access token
$client->authenticate($access);

// Use the client
$client->constituent()->get(1);
```

## Usage

### Constituent Resource

`GET` - Retrieve constituent information by ID

```php
$constituent = $client->constituent()->get(1); // Blackbaud\Data\Constituent DTO
```

`CREATE` - Create a constituent by providing an array

```php
use Blackbaud\Enums\ConstituentType;

$newlyCreatedId = $client->constituent()->create([
    'last' => 'LastName',
    'type' => ConstituentType::Individual,
]); // int
```


`UPDATE` - Update an existing constituent by providing an ID and array

```php
use Blackbaud\Enums\ConstituentType;

$client->constituent()->update(1, ['last' => 'UpdatedLastName']); // true if request is successful
```
### Other Resource

These other resources available follow the same pattern with the constituent resource

```php
// GiftResource
$client->gift()->get(1);

// EventResource
$client->event()->get(1);
```

## Testing

```bash
composer test
```
