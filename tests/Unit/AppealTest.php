<?php

use Blackbaud\Blackbaud;
use Blackbaud\Data\ApiCollection;
use Blackbaud\Data\Fundraiser\Appeal;
use Blackbaud\Requests\Fundraising\GetAllAppeal;
use Carbon\CarbonImmutable;

$client = Blackbaud::oauth('client-id', 'client-secret', 'redirect-url', 'subscription-key');

it('can retrieve appeal information', function () use ($client): void {
    $appeal = $client->appeal()->get(12);

    expect($appeal)->toBeInstanceOf(Appeal::class)
        ->and($appeal->id)->toBe('12')
        ->and($appeal->category)->toBe('Annual')
        ->and($appeal->description)->toBe('Spring Appeal 2025')
        ->and($appeal->goal)->toBe(50000.0)
        ->and($appeal->inactive)->toBeFalse()
        ->and($appeal->lookup_id)->toBe('SPRING25')
        ->and($appeal->start_date?->toDateString())->toBe('2025-03-01')
        ->and($appeal->end_date?->toDateString())->toBe('2025-06-30')
        ->and($appeal->date_added)->toBeInstanceOf(CarbonImmutable::class)
        ->and($appeal->date_modified)->toBeInstanceOf(CarbonImmutable::class);
});

it('can retrieve all appeals', function () use ($client): void {
    $appeals = $client->appeal()->all(includeInactive: true);

    expect($appeals)->toBeInstanceOf(ApiCollection::class)
        ->and($appeals->count)->toBe(2)
        ->and($appeals->nextLink)->toBe('https://api.sky.blackbaud.com/fundraising/v1/appeals?offset=2&limit=2')
        ->and($appeals->value)->toHaveCount(2)
        ->and($appeals->value)->each->toBeInstanceOf(Appeal::class)
        ->and($appeals->value[1]->goal)->toBeNull()
        ->and($appeals->value[1]->start_date)->toBeNull();
});

it('sends the appeal list filters as query parameters', function (): void {
    $request = new GetAllAppeal(
        CarbonImmutable::parse('2025-01-01T00:00:00+00:00'),
        CarbonImmutable::parse('2025-02-01T00:00:00+00:00'),
        'token',
        50,
        100,
        true,
    );

    expect($request->resolveEndpoint())->toBe('/fundraising/v1/appeals')
        ->and($request->query()->all())->toBe([
            'date_added' => '2025-01-01T00:00:00+00:00',
            'last_modified' => '2025-02-01T00:00:00+00:00',
            'sort_token' => 'token',
            'include_inactive' => 'true',
            'limit' => 50,
            'offset' => 100,
        ]);
});
