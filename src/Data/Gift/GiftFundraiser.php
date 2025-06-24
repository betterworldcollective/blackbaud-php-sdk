<?php

namespace BlackbaudSdk\Data\Gift;

use BlackbaudSdk\Contracts\Data;
use BlackbaudSdk\Data\BaseData;

/**
 * @phpstan-type CurrencyResponse array{value: float}
 * @phpstan-type GiftFundraiserDataResponse array{
 *     amount: CurrencyResponse,
 *     constituent_id: string,
 * }
 */
class GiftFundraiser extends BaseData implements Data
{
    public function __construct(
        public float $amount,
        public string $constituent_id,
    ) {}

    /**
     * @param  GiftFundraiserDataResponse  $data
     */
    public static function from(array $data): GiftFundraiser
    {
        return new self(
            amount: $data['amount']['value'],
            constituent_id: $data['constituent_id'],
        );
    }
}
