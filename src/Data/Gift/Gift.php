<?php

namespace Blackbaud\Data\Gift;

use Blackbaud\Data\BaseData;
use Blackbaud\Data\FuzzyDate;
use Blackbaud\Enums\GiftAidQualificationStatus;
use Blackbaud\Enums\GiftStatus;
use Blackbaud\Enums\GiftType;
use Blackbaud\Enums\PostStatus;
use Carbon\CarbonImmutable;

/**
 * @phpstan-type CurrencyResponse array{value: float}
 *
 * @phpstan-import-type AcknowledgementDataResponse from Acknowledgement
 * @phpstan-import-type GiftFundraiserDataResponse from GiftFundraiser
 * @phpstan-import-type GiftSplitDataResponse from GiftSplit
 * @phpstan-import-type PaymentDataResponse from Payment
 * @phpstan-import-type ReceiptDataResponse from Receipt
 * @phpstan-import-type RecurringGiftScheduleDataResponse from RecurringGiftSchedule
 * @phpstan-import-type SoftCreditDataResponse from SoftCredit
 *
 * @phpstan-type GiftDataResponse array{
 *     id: string,
 *     amount: CurrencyResponse,
 *     acknowledgements: array<AcknowledgementDataResponse>,
 *     constituent_id: string,
 *     date: string,
 *     date_added: string,
 *     date_modified: string,
 *     gift_aid_qualification_status: string,
 *     gift_splits: array<GiftSplitDataResponse>,
 *     gift_status: string,
 *     payments: array<PaymentDataResponse>,
 *     post_status: string,
 *     receipts: array<ReceiptDataResponse>,
 *     type: string,
 *     balance?: CurrencyResponse|null,
 *     batch_number?: string|null,
 *     fundraisers?: array<GiftFundraiserDataResponse>|null,
 *     gift_aid_amount?: CurrencyResponse|null,
 *     gift_code?: string|null,
 *     is_anonymous?: bool|null,
 *     linked_gifts?: array<string>|null,
 *     constituency?: string|null,
 *     lookup_id?: string|null,
 *     origin?: string|null,
 *     post_date?: string|null,
 *     recurring_gift_schedule?: RecurringGiftScheduleDataResponse|null,
 *     recurring_gift_status_date?: array{y: int, m: int, d: int}|null,
 *     reference?: string|null,
 *     soft_credits?: array<SoftCreditDataResponse>|null,
 *     subtype?: string|null
 * }
 */
class Gift extends BaseData
{
    /**
     * @param  array<Acknowledgement>  $acknowledgements
     * @param  array<GiftSplit>  $gift_splits
     * @param  array<Payment>  $payments
     * @param  array<Receipt>  $receipts
     * @param  array<GiftFundraiser>  $fundraisers
     * @param  array<string>  $linked_gifts
     * @param  array<SoftCredit>  $soft_credits
     */
    public function __construct(
        public string $id,
        public float $amount,
        public array $acknowledgements,
        public string $constituent_id,
        public CarbonImmutable $date,
        public CarbonImmutable $date_added,
        public CarbonImmutable $date_modified,
        public GiftAidQualificationStatus $gift_aid_qualification_status,
        public array $gift_splits,
        public GiftStatus $gift_status,
        public array $payments,
        public PostStatus $post_status,
        public array $receipts,
        public GiftType $type,
        public ?float $balance = null,
        public ?string $batch_number = null,
        public ?array $fundraisers = null,
        public ?float $gift_aid_amount = null,
        public ?string $gift_code = null,
        public ?bool $is_anonymous = null,
        public ?array $linked_gifts = null,
        public ?string $constituency = null,
        public ?string $lookup_id = null,
        public ?string $origin = null,
        public ?CarbonImmutable $post_date = null,
        public ?RecurringGiftSchedule $recurring_gift_schedule = null,
        public ?CarbonImmutable $recurring_gift_status_date = null,
        public ?string $reference = null,
        public ?array $soft_credits = null,
        public ?string $subtype = null,
    ) {}

    /**
     * @param  GiftDataResponse  $data
     */
    public static function from(array $data): Gift
    {
        return new self(
            id: $data['id'],
            amount: $data['amount']['value'],
            acknowledgements: array_map([Acknowledgement::class, 'from'], $data['acknowledgements']),
            constituent_id: $data['constituent_id'],
            date: CarbonImmutable::parse($data['date']),
            date_added: CarbonImmutable::parse($data['date_added']),
            date_modified: CarbonImmutable::parse($data['date_modified']),
            gift_aid_qualification_status: GiftAidQualificationStatus::from($data['gift_aid_qualification_status']),
            gift_splits: array_map([GiftSplit::class, 'from'], $data['gift_splits']),
            gift_status: GiftStatus::from($data['gift_status']),
            payments: array_map([Payment::class, 'from'], $data['payments']),
            post_status: PostStatus::from($data['post_status']),
            receipts: array_map([Receipt::class, 'from'], $data['receipts']),
            type: GiftType::from($data['type']),
            balance: isset($data['balance'])
                ? $data['balance']['value']
                : null,
            batch_number: $data['batch_number'] ?? null,
            fundraisers: isset($data['fundraisers'])
                ? array_map([GiftFundraiser::class, 'from'], $data['fundraisers'])
                : null,
            gift_aid_amount: isset($data['gift_aid_amount'])
                ? $data['gift_aid_amount']['value']
                : null,
            gift_code: $data['gift_code'] ?? null,
            is_anonymous: $data['is_anonymous'] ?? null,
            linked_gifts: $data['linked_gifts'] ?? null,
            constituency: $data['constituency'] ?? null,
            lookup_id: $data['lookup_id'] ?? null,
            origin: $data['origin'] ?? null,
            post_date: isset($data['post_date'])
                ? CarbonImmutable::parse($data['post_date'])
                : null,
            recurring_gift_schedule: self::convertToData($data, 'recurring_gift_schedule', RecurringGiftSchedule::class),
            recurring_gift_status_date: FuzzyDate::toCarbon($data['recurring_gift_status_date'] ?? null),
            reference: $data['reference'] ?? null,
            soft_credits: isset($data['soft_credits'])
                ? array_map([SoftCredit::class, 'from'], $data['soft_credits'])
                : null,
            subtype: $data['subtype'] ?? null,
        );
    }
}
