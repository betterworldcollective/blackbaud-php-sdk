<?php

namespace BlackbaudSdk\Data\Gift;

use BlackbaudSdk\Contracts\Data;
use BlackbaudSdk\Data\BaseData;
use BlackbaudSdk\Enums\RecurringGiftFrequency;
use Carbon\CarbonImmutable;

/**
 * @phpstan-type RecurringGiftScheduleDataResponse array{
 *     end_date?: string|null,
 *     frequency: string,
 *     start_date: string,
 *     next_transaction_date?: string|null
 * }
 */
class RecurringGiftSchedule extends BaseData implements Data
{
    public function __construct(
        public RecurringGiftFrequency $frequency,
        public CarbonImmutable $start_date,
        public ?CarbonImmutable $end_date = null,
        public ?CarbonImmutable $next_transaction_date = null,
    ) {}

    /**
     * @param  RecurringGiftScheduleDataResponse  $data
     */
    public static function from(array $data): RecurringGiftSchedule
    {
        /** @var ?string $endDate */
        $endDate = data_get($data, 'end_date');

        /** @var ?string $nextTransactionDate */
        $nextTransactionDate = data_get($data, 'next_transaction_date');

        return new self(
            frequency: RecurringGiftFrequency::from($data['frequency']),
            start_date: CarbonImmutable::parse($data['start_date']),
            end_date: $endDate
                ? CarbonImmutable::parse($endDate)
                : null,
            next_transaction_date: $nextTransactionDate
                ? CarbonImmutable::parse($nextTransactionDate)
                : null,
        );
    }
}
