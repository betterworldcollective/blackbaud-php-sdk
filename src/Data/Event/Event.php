<?php

namespace Blackbaud\Data\Event;

use Blackbaud\Contracts\Data;
use Blackbaud\Data\BaseData;
use Carbon\CarbonImmutable;

/**
 * @phpstan-import-type EventCategoryResponseData from EventCategory
 * @phpstan-import-type EventGroupResponseData from EventGroup
 * @phpstan-import-type LocationResponseData from Location
 *
 * @phpstan-type EventDataResponse array{
 *     id: string,
 *     category?: EventCategoryResponseData|null,
 *     group?: EventGroupResponseData|null,
 *     location?: LocationResponseData|null,
 *     date_added?: string|null,
 *     date_modified?: string|null,
 *     lookup_id?: string|null,
 *     name: string,
 *     description?: string|null,
 *     start_date: string,
 *     start_time?: string|null,
 *     end_date?: string|null,
 *     end_time?: string|null,
 *     inactive?: bool|null,
 *     capacity?: int|null,
 *     goal?: float|null,
 *     campaign_id?: string|null,
 *     fund_id?: string|null,
 *     appeal_id?: string|null,
 *     package_id?: string|null
 * }
 */
class Event extends BaseData implements Data
{
    public function __construct(
        public string $id,
        public string $name,
        public CarbonImmutable $start_date,
        public ?EventCategory $category = null,
        public ?EventGroup $group = null,
        public ?Location $location = null,
        public ?CarbonImmutable $date_added = null,
        public ?CarbonImmutable $date_modified = null,
        public ?string $lookup_id = null,
        public ?string $description = null,
        public ?CarbonImmutable $end_date = null,
        public ?bool $inactive = null,
        public ?int $capacity = null,
        public ?float $goal = null,
        public ?string $campaign_id = null,
        public ?string $fund_id = null,
        public ?string $appeal_id = null,
        public ?string $package_id = null,
    ) {}

    /** @param EventDataResponse $data */
    public static function from(array $data): Event
    {
        /** @var ?string $dateAdded */
        $dateAdded = data_get($data, 'date_added');

        /** @var ?string $dateModified */
        $dateModified = data_get($data, 'date_modified');

        /** @var ?string $endDate */
        $endDate = data_get($data, 'end_date');

        /** @var string $endTime */
        $endTime = data_get($data, 'end_time', '');

        /** @var string $startTime */
        $startTime = data_get($data, 'start_time', '');

        return new self(
            id: $data['id'],
            name: $data['name'],
            start_date: CarbonImmutable::parse("{$data['start_date']} {$startTime}"),
            category: self::convertToData($data, 'category', EventCategory::class),
            group: self::convertToData($data, 'group', EventGroup::class),
            location: self::convertToData($data, 'location', Location::class),
            date_added: $dateAdded
                ? CarbonImmutable::parse($dateAdded)
                : null,
            date_modified: $dateModified
                ? CarbonImmutable::parse($dateModified)
                : null,
            lookup_id: $data['lookup_id'] ?? null,
            description: $data['description'] ?? null,
            end_date: $endDate
                ? CarbonImmutable::parse("{$endDate} {$endTime}")
                : null,
            inactive: $data['inactive'] ?? null,
            capacity: $data['capacity'] ?? null,
            goal: $data['goal'] ?? null,
            campaign_id: $data['campaign_id'] ?? null,
            fund_id: $data['fund_id'] ?? null,
            appeal_id: $data['appeal_id'] ?? null,
            package_id: $data['package_id'] ?? null,
        );
    }
}
