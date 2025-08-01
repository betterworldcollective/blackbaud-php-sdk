<?php

use Blackbaud\Requests\Constituent\CreateConstituent;
use Blackbaud\Requests\Constituent\GetConstituent;
use Blackbaud\Requests\Constituent\UpdateConstituent;
use Blackbaud\Requests\Event\CreateEvent;
use Blackbaud\Requests\Event\GetEvent;
use Blackbaud\Requests\Event\UpdateEvent;
use Blackbaud\Requests\Gift\CreateGift;
use Blackbaud\Requests\Gift\GetGift;
use Blackbaud\Requests\Gift\UpdateGift;
use Saloon\Config;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Saloon\MockConfig;

MockConfig::setFixturePath('tests/Fixtures');
MockConfig::throwOnMissingFixtures();
Config::preventStrayRequests();

MockClient::global([
    GetConstituent::class => MockResponse::fixture('constituent'),
    CreateConstituent::class => MockResponse::fixture('constituent-create'),
    UpdateConstituent::class => MockResponse::fixture('constituent-update'),
    GetGift::class => MockResponse::fixture('gift'),
    CreateGift::class => MockResponse::fixture('gift-create'),
    UpdateGift::class => MockResponse::fixture('gift-update'),
    GetEvent::class => MockResponse::fixture('event'),
    CreateEvent::class => MockResponse::fixture('event-create'),
    UpdateEvent::class => MockResponse::fixture('event-update'),
]);

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "pest()" function to bind different classes or traits.
|
*/

pest()->extend(Blackbaud\Tests\TestCase::class)->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function something()
{
    // ..
}
