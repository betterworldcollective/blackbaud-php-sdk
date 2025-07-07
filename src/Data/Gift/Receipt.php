<?php

namespace Blackbaud\Data\Gift;

use Blackbaud\Data\BaseData;
use Blackbaud\Enums\GiftReceiptStatus;
use Carbon\CarbonImmutable;

/**
 * @phpstan-type CurrencyResponse array{value: float}
 * @phpstan-type ReceiptDataResponse array{
 *     amount: CurrencyResponse,
 *     date?: string|null,
 *     number?: int|null,
 *     status: string
 * }
 */
class Receipt extends BaseData
{
    public function __construct(
        public float $amount,
        public GiftReceiptStatus $status,
        public ?CarbonImmutable $date = null,
        public ?int $number = null,
    ) {}

    /**
     * @param  ReceiptDataResponse  $data
     */
    public static function from(array $data): Receipt
    {
        /** @var ?string $date */
        $date = data_get($data, 'date');

        return new self(
            amount: $data['amount']['value'],
            status: GiftReceiptStatus::from($data['status']),
            date: $date
                ? CarbonImmutable::parse($date)
                : null,
            number: $data['number'] ?? null,
        );
    }
}
