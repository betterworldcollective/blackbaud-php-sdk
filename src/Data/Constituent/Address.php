<?php

namespace Blackbaud\Data\Constituent;

use Blackbaud\Data\BaseData;
use Blackbaud\Data\FuzzyDate;
use Carbon\CarbonImmutable;

/**
 * @phpstan-type AddressDataResponse array{
 *     id: string,
 *     constituent_id?: string|null,
 *     address_lines?: string|null,
 *     city?: string|null,
 *     country?: string|null,
 *     county?: string|null,
 *     formatted_address?: string|null,
 *     postal_code?: string|null,
 *     state?: string|null,
 *     suburb?: string|null,
 *     type?: string|null,
 *     seasonal_start?: array{y: int, m: int, d: int}|null,
 *     seasonal_end?: array{y: int, m: int, d: int}|null,
 *     do_not_mail: bool,
 *     inactive: bool,
 *     preferred: bool,
 *     date_added?: string|null,
 *     date_modified?: string|null,
 *     start?: string|null,
 *     end?: string|null
 * }
 */
class Address extends BaseData
{
    public function __construct(
        public string $id,
        public ?string $constituent_id = null,
        public ?string $address_lines = null,
        public ?string $city = null,
        public ?string $country = null,
        public ?string $county = null,
        public ?string $formatted_address = null,
        public ?string $postal_code = null,
        public ?string $state = null,
        public ?string $suburb = null,
        public ?string $type = null,
        public bool $do_not_mail = false,
        public bool $inactive = false,
        public bool $preferred = false,
        public ?CarbonImmutable $date_added = null,
        public ?CarbonImmutable $date_modified = null,
        public ?CarbonImmutable $start = null,
        public ?CarbonImmutable $end = null,
        public ?CarbonImmutable $seasonal_start = null,
        public ?CarbonImmutable $seasonal_end = null,
    ) {}

    /**
     * @param  AddressDataResponse  $data
     */
    public static function from(array $data): Address
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
            constituent_id: $data['constituent_id'] ?? null,
            address_lines: $data['address_lines'] ?? null,
            city: $data['city'] ?? null,
            country: $data['country'] ?? null,
            county: $data['county'] ?? null,
            formatted_address: $data['formatted_address'] ?? null,
            postal_code: $data['postal_code'] ?? null,
            state: $data['state'] ?? null,
            suburb: $data['suburb'] ?? null,
            type: $data['type'] ?? null,
            do_not_mail: $data['do_not_mail'],
            inactive: $data['inactive'],
            preferred: $data['preferred'],
            date_added: $dateAdded
                ? CarbonImmutable::parse($dateAdded)
                : null,
            date_modified: $dateModified
                ? CarbonImmutable::parse($dateModified)
                : null,
            start: $start
                ? CarbonImmutable::parse($start)
                : null,
            end: $end
                ? CarbonImmutable::parse($end)
                : null,
            seasonal_start: FuzzyDate::toCarbon($data['seasonal_start'] ?? null),
            seasonal_end: FuzzyDate::toCarbon($data['seasonal_end'] ?? null)
        );
    }
}
