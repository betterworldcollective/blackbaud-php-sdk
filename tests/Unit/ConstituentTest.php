<?php

use Blackbaud\Blackbaud;
use Blackbaud\Data\Constituent\Constituent;
use Blackbaud\Enums\ConstituentType;

$client = Blackbaud::oauth('client-id', 'client-secret', 'redirect-url', 'subscription-key');

it('can retrieve constituent information', function () use ($client) {
    $constituent = $client->constituent()->get(280);

    expect($constituent)->toBeInstanceOf(Constituent::class)->and($constituent->id)->toBe('280');
});

it('can create constituent information', function () use ($client) {
    $newlyCreatedId = $client->constituent()->create([
        'last' => 'LastName',
        'type' => ConstituentType::Individual,
    ]);

    expect($newlyCreatedId)->toBe(143);
});

it('can update constituent information', function () use ($client) {
    expect($client->constituent()->update(123, [
        'last' => 'UpdatedLastName',
    ]))->toBeTrue();
});

it('can update constituent address', function () use ($client) {
    expect($client->constituentAddress()->update(456, [
        'address_lines' => '123 Main St',
        'city' => 'Austin',
        'state' => 'TX',
        'postal_code' => '78701',
    ]))->toBeTrue();
});

it('can update constituent phone', function () use ($client) {
    expect($client->constituentPhone()->update(789, [
        'number' => '555-0100',
        'type' => 'Mobile',
        'primary' => true,
    ]))->toBeTrue();
});
