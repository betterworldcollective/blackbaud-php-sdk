<?php

use Blackbaud\Blackbaud;
use Blackbaud\Data\ApiCollection;
use Blackbaud\Data\Fundraiser\Package;
use Blackbaud\Requests\Fundraising\GetAllPackage;
use Carbon\CarbonImmutable;

$client = Blackbaud::oauth('client-id', 'client-secret', 'redirect-url', 'subscription-key');

it('can retrieve package information', function () use ($client): void {
    $package = $client->package()->get(48);

    expect($package)->toBeInstanceOf(Package::class)
        ->and($package->id)->toBe('48')
        ->and($package->appeal_id)->toBe('12')
        ->and($package->category)->toBe('Direct Mail')
        ->and($package->description)->toBe('Spring Mailer')
        ->and($package->default_gift_amount)->toBe(25.0)
        ->and($package->goal)->toBe(10000.0)
        ->and($package->inactive)->toBeFalse()
        ->and($package->lookup_id)->toBe('SPRING25-DM')
        ->and($package->notes)->toBe('Sent to lapsed donors')
        ->and($package->recipient_count)->toBe(1200)
        ->and($package->start?->toDateString())->toBe('2025-03-15')
        ->and($package->end?->toDateString())->toBe('2025-05-31')
        ->and($package->date_added)->toBeInstanceOf(CarbonImmutable::class)
        ->and($package->date_modified)->toBeInstanceOf(CarbonImmutable::class);
});

it('can retrieve all packages', function () use ($client): void {
    $packages = $client->package()->all(appealId: 12);

    expect($packages)->toBeInstanceOf(ApiCollection::class)
        ->and($packages->count)->toBe(2)
        ->and($packages->nextLink)->toBeNull()
        ->and($packages->value)->toHaveCount(2)
        ->and($packages->value)->each->toBeInstanceOf(Package::class)
        ->and($packages->value[1]->default_gift_amount)->toBeNull()
        ->and($packages->value[1]->recipient_count)->toBeNull();
});

it('sends the package list filters as query parameters', function (): void {
    $request = new GetAllPackage(
        CarbonImmutable::parse('2025-01-01T00:00:00+00:00'),
        CarbonImmutable::parse('2025-02-01T00:00:00+00:00'),
        'token',
        50,
        100,
        true,
        12,
    );

    expect($request->resolveEndpoint())->toBe('/fundraising/v1/packages')
        ->and($request->query()->all())->toBe([
            'appeal_id' => 12,
            'date_added' => '2025-01-01T00:00:00+00:00',
            'last_modified' => '2025-02-01T00:00:00+00:00',
            'sort_token' => 'token',
            'include_inactive' => 'true',
            'limit' => 50,
            'offset' => 100,
        ]);
});
