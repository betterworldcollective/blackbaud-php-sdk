<?php

namespace Blackbaud\Data\Event;

use Blackbaud\Data\BaseData;

/**
 * @phpstan-import-type LocalityResponseData from Locality
 * @phpstan-import-type AdministrativeAreaResponseData from AdministrativeArea
 * @phpstan-import-type SubAdministrativeAreaResponseData from SubAdministrativeArea
 * @phpstan-import-type CountryResponseData from Country
 *
 * @phpstan-type LocationResponseData array{
 *     name?: string|null,
 *     address_lines?: string|null,
 *     postal_code?: string|null,
 *     locality?: LocalityResponseData|null,
 *     administrative_area?: AdministrativeAreaResponseData|null,
 *     sub_administrative_area?: SubAdministrativeAreaResponseData|null,
 *     country?: CountryResponseData|null,
 *     formatted_address?: string|null,
 *     phone?: string|null,
 *     contact?: string|null,
 *     notes?: string|null
 * }
 */
class Location extends BaseData
{
    public function __construct(
        public ?string $name = null,
        public ?string $address_lines = null,
        public ?string $postal_code = null,
        public ?Locality $locality = null,
        public ?AdministrativeArea $administrative_area = null,
        public ?SubAdministrativeArea $sub_administrative_area = null,
        public ?Country $country = null,
        public ?string $formatted_address = null,
        public ?string $phone = null,
        public ?string $contact = null,
        public ?string $notes = null,
    ) {}

    /** @param LocationResponseData $data */
    public static function from(array $data): Location
    {
        return new self(
            name: $data['name'] ?? null,
            address_lines: $data['address_lines'] ?? null,
            postal_code: $data['postal_code'] ?? null,
            locality: self::convertToData($data, 'locality', Locality::class),
            administrative_area: self::convertToData($data, 'administrative_area', AdministrativeArea::class),
            sub_administrative_area: self::convertToData($data, 'sub_administrative_area', SubAdministrativeArea::class),
            country: self::convertToData($data, 'country', Country::class),
            formatted_address: $data['formatted_address'] ?? null,
            phone: $data['phone'] ?? null,
            contact: $data['contact'] ?? null,
            notes: $data['notes'] ?? null,
        );
    }
}
