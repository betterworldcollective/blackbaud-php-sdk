<?php

namespace Blackbaud\Data\Fundraiser;

use Blackbaud\Data\BaseData;
use Carbon\CarbonImmutable;

/**
 * @phpstan-type CurrencyResponse array{ value: float }
 * @phpstan-type FundDataResponse array{
 *     id: string,
 *     category?: string|null,
 *     date_added?: string|null,
 *     date_modified?: string|null,
 *     description?: string|null,
 *     end_date?: string|null,
 *     goal?: CurrencyResponse|null,
 *     inactive?: bool|null,
 *     lookup_id?: string|null,
 *     start_date?: string|null,
 *     type?: string|null
 * }
 */
class Fund extends BaseData
{
    public function __construct(
        public string $id,
        public ?string $category = null,
        public ?CarbonImmutable $date_added = null,
        public ?CarbonImmutable $date_modified = null,
        public ?string $description = null,
        public ?CarbonImmutable $end_date = null,
        public ?float $goal = null,
        public ?bool $inactive = null,
        public ?string $lookup_id = null,
        public ?CarbonImmutable $start_date = null,
        public ?string $type = null,
    ) {}

    /**
     * @param  FundDataResponse  $data
     */
    public static function from(array $data): Fund
    {
        /** @var ?string $dateAdded */
        $dateAdded = data_get($data, 'date_added');

        /** @var ?string $dateModified */
        $dateModified = data_get($data, 'date_modified');

        /** @var ?string $startDate */
        $startDate = data_get($data, 'start_date');

        /** @var ?string $endDate */
        $endDate = data_get($data, 'end_date');

        return new self(
            id: $data['id'],
            category: $data['category'] ?? null,
            date_added: $dateAdded ? CarbonImmutable::parse($dateAdded) : null,
            date_modified: $dateModified ? CarbonImmutable::parse($dateModified) : null,
            description: $data['description'] ?? null,
            end_date: $endDate ? CarbonImmutable::parse($endDate) : null,
            goal: $data['goal']['value'] ?? null,
            inactive: $data['inactive'] ?? null,
            lookup_id: $data['lookup_id'] ?? null,
            start_date: $startDate ? CarbonImmutable::parse($startDate) : null,
            type: $data['type'] ?? null,
        );
    }
}
