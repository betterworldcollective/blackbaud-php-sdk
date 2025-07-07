<?php

namespace Blackbaud\Data\Gift;

use Blackbaud\Data\BaseData;

/**
 * @phpstan-type CurrencyResponse array{value: float}
 * @phpstan-type SoftCreditDataResponse array{
 *     id?: string|null,
 *     amount?: CurrencyResponse|null,
 *     constituent_id?: string|null,
 *     gift_id?: string|null
 * }
 */
class SoftCredit extends BaseData
{
    public function __construct(
        public ?float $amount = null,
        public ?string $id = null,
        public ?string $constituent_id = null,
        public ?string $gift_id = null,
    ) {}

    /**
     * @param  SoftCreditDataResponse  $data
     */
    public static function from(array $data): SoftCredit
    {
        return new self(
            amount: isset($data['amount']) ? $data['amount']['value'] : null,
            id: $data['id'] ?? null,
            constituent_id: $data['constituent_id'] ?? null,
            gift_id: $data['gift_id'] ?? null,
        );
    }
}
