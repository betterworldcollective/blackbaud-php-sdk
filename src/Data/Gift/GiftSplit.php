<?php

namespace Blackbaud\Data\Gift;

use Blackbaud\Contracts\Data;
use Blackbaud\Data\BaseData;
use Blackbaud\Enums\GiftAidQualificationStatus;

/**
 * @phpstan-type CurrencyResponse array{value: float}
 * @phpstan-type GiftSplitDataResponse array{
 *     id: string,
 *     fund_id: string,
 *     amount: CurrencyResponse,
 *     appeal_id?: string|null,
 *     campaign_id?: string|null,
 *     gift_aid_amount?: CurrencyResponse|null,
 *     gift_aid_qualification_status?: string|null,
 *     package_id?: string|null
 * }
 */
class GiftSplit extends BaseData implements Data
{
    public function __construct(
        public string $id,
        public string $fund_id,
        public float $amount,
        public ?GiftAidQualificationStatus $gift_aid_qualification_status = null,
        public ?string $appeal_id = null,
        public ?string $campaign_id = null,
        public ?float $gift_aid_amount = null,
        public ?string $package_id = null,
    ) {}

    /**
     * @param  GiftSplitDataResponse  $data
     */
    public static function from(array $data): GiftSplit
    {
        /** @var string|null $giftAidQualificationStatus */
        $giftAidQualificationStatus = data_get($data, 'gift_aid_qualification_status');

        return new self(
            id: $data['id'],
            fund_id: $data['fund_id'],
            amount: $data['amount']['value'],
            gift_aid_qualification_status: GiftAidQualificationStatus::tryFrom($giftAidQualificationStatus ?? ''),
            appeal_id: $data['appeal_id'] ?? null,
            campaign_id: $data['campaign_id'] ?? null,
            gift_aid_amount: isset($data['gift_aid_amount']) ? $data['gift_aid_amount']['value'] : null,
            package_id: $data['package_id'] ?? null,
        );
    }
}
