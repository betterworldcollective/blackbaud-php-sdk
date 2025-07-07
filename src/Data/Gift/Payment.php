<?php

namespace Blackbaud\Data\Gift;

use Blackbaud\Data\BaseData;
use Blackbaud\Data\FuzzyDate;
use Blackbaud\Enums\GiftPaymentMethod;
use Carbon\CarbonImmutable;

/**
 * @phpstan-type PaymentDataResponse array{
 *     account_token?: string|null,
 *     bbps_configuration_id?: string|null,
 *     bbps_transaction_id?: string|null,
 *     check_date?: array{y: int, m: int, d: int}|null,
 *     check_number?: string|null,
 *     checkout_transaction_id?: string|null,
 *     payment_method: string,
 *     reference?: string|null,
 *     reference_date?: array{y: int, m: int, d: int}|null
 * }
 */
class Payment extends BaseData
{
    public function __construct(
        public GiftPaymentMethod $payment_method,
        public ?string $account_token = null,
        public ?string $bbps_configuration_id = null,
        public ?string $bbps_transaction_id = null,
        public ?CarbonImmutable $check_date = null,
        public ?string $check_number = null,
        public ?string $checkout_transaction_id = null,
        public ?string $reference = null,
        public ?CarbonImmutable $reference_date = null,
    ) {}

    /**
     * @param  PaymentDataResponse  $data
     */
    public static function from(array $data): Payment
    {
        return new self(
            payment_method: GiftPaymentMethod::from($data['payment_method']),
            account_token: $data['account_token'] ?? null,
            bbps_configuration_id: $data['bbps_configuration_id'] ?? null,
            bbps_transaction_id: $data['bbps_transaction_id'] ?? null,
            check_date: FuzzyDate::toCarbon($data['check_date'] ?? null),
            check_number: $data['check_number'] ?? null,
            checkout_transaction_id: $data['checkout_transaction_id'] ?? null,
            reference: $data['reference'] ?? null,
            reference_date: FuzzyDate::toCarbon($data['reference_date'] ?? null),
        );
    }
}
