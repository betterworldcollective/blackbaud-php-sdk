<?php

namespace Blackbaud\Data\Fundraiser;

use Blackbaud\Data\BaseData;
use Carbon\CarbonImmutable;

/**
 * Packages name their date fields `start` and `end`, unlike appeals and funds which use `start_date` and `end_date`.
 *
 * @phpstan-type CurrencyResponse array{ value: float }
 * @phpstan-type PackageDataResponse array{
 *     id: string,
 *     appeal_id?: string|null,
 *     category?: string|null,
 *     date_added?: string|null,
 *     date_modified?: string|null,
 *     default_gift_amount?: CurrencyResponse|null,
 *     description?: string|null,
 *     end?: string|null,
 *     goal?: CurrencyResponse|null,
 *     inactive?: bool|null,
 *     lookup_id?: string|null,
 *     notes?: string|null,
 *     recipient_count?: int|null,
 *     start?: string|null
 * }
 */
class Package extends BaseData
{
    public function __construct(
        public string $id,
        public ?string $appeal_id = null,
        public ?string $category = null,
        public ?CarbonImmutable $date_added = null,
        public ?CarbonImmutable $date_modified = null,
        public ?float $default_gift_amount = null,
        public ?string $description = null,
        public ?CarbonImmutable $end = null,
        public ?float $goal = null,
        public ?bool $inactive = null,
        public ?string $lookup_id = null,
        public ?string $notes = null,
        public ?int $recipient_count = null,
        public ?CarbonImmutable $start = null,
    ) {}

    /**
     * @param  PackageDataResponse  $data
     */
    public static function from(array $data): Package
    {
        /** @var ?string $dateAdded */
        $dateAdded = data_get($data, 'date_added');

        /** @var ?string $dateModified */
        $dateModified = data_get($data, 'date_modified');

        /** @var ?string $start */
        $start = data_get($data, 'start');

        /** @var ?string $end */
        $end = data_get($data, 'end');

        return new self(
            id: $data['id'],
            appeal_id: $data['appeal_id'] ?? null,
            category: $data['category'] ?? null,
            date_added: $dateAdded ? CarbonImmutable::parse($dateAdded) : null,
            date_modified: $dateModified ? CarbonImmutable::parse($dateModified) : null,
            default_gift_amount: $data['default_gift_amount']['value'] ?? null,
            description: $data['description'] ?? null,
            end: $end ? CarbonImmutable::parse($end) : null,
            goal: $data['goal']['value'] ?? null,
            inactive: $data['inactive'] ?? null,
            lookup_id: $data['lookup_id'] ?? null,
            notes: $data['notes'] ?? null,
            recipient_count: $data['recipient_count'] ?? null,
            start: $start ? CarbonImmutable::parse($start) : null,
        );
    }
}
