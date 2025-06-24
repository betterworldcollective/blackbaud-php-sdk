<?php

use BlackbaudSdk\Blackbaud;
use BlackbaudSdk\Data\Gift\Gift;
use BlackbaudSdk\Enums\GiftPaymentMethod;
use BlackbaudSdk\Enums\GiftType;

$client = Blackbaud::oauth('client-id', 'client-secret', 'redirect-url', 'subscription-key');

it('can retrieve gift information', function () use ($client): void {
    $gift = $client->gift()->get(280);

    expect($gift)->toBeInstanceOf(Gift::class)->and($gift->id)->toBe('1140');
});

it('can create gift information', function () use ($client): void {
    $newlyCreatedId = $client->gift()->create([
        'amount' => [
            'value' => 100,
        ],
        'constituent_id' => 593638,
        'gift_splits' => [
            [
                'fund_id' => 18,
                'amount' => [
                    'value' => 100,
                ],
            ],
        ],
        'payments' => [
            [
                'payment_method' => GiftPaymentMethod::Cash,
            ],
        ],
        'type' => GiftType::Donation,
    ]);

    expect($newlyCreatedId)->toBe(4442);
});

it('can update gift information', function () use ($client): void {
    expect($client->gift()->update(123, [
        'gift_code' => 'TestGiftCode',
    ]))->toBeTrue();
});
