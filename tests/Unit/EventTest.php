<?php

use BlackbaudSdk\Blackbaud;
use BlackbaudSdk\Data\Event\Event;

$client = Blackbaud::oauth('client-id', 'client-secret', 'redirect-url', 'subscription-key');

it('can retrieve event information', function () use ($client): void {
    $gift = $client->event()->get(1);

    expect($gift)->toBeInstanceOf(Event::class)->and($gift->id)->toBe('1');
});

it('can create event information', function () use ($client): void {
    $newlyCreatedId = $client->event()->create([
        'name' => 'New Event',
        'start_date' => '2025-12-01',
    ]);

    expect($newlyCreatedId)->toBe(92962);
});

it('can update event information', function () use ($client): void {
    expect($client->gift()->update(92962, [
        'name' => 'New Event 2',
    ]))->toBeTrue();
});
