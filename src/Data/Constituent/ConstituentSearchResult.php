<?php

namespace Blackbaud\Data\Constituent;

use Blackbaud\Data\BaseData;

/**
 * @phpstan-type ConstituentSearchResultDataResponse array{
 *     id: string,
 *     lookup_id?: string|null,
 *     name?: string|null,
 *     first_name?: string|null,
 *     last_name?: string|null,
 *     middle_name?: string|null,
 *     preferred_name?: string|null,
 *     former_name?: string|null,
 *     suffix?: string|null,
 *     title?: string|null,
 *     gender?: string|null,
 *     key_indicator?: string|null,
 *     maiden_name?: string|null,
 *     org_name?: string|null,
 *     address?: string|null,
 *     address_block?: string|null,
 *     address_city_state?: string|null,
 *     address_post_code?: string|null,
 *     primary_email?: string|null,
 *     inactive?: bool
 * }
 */
class ConstituentSearchResult extends BaseData
{
    public function __construct(
        public string $id,
        public ?string $lookup_id = null,
        public ?string $name = null,
        public ?string $first_name = null,
        public ?string $last_name = null,
        public ?string $middle_name = null,
        public ?string $preferred_name = null,
        public ?string $former_name = null,
        public ?string $suffix = null,
        public ?string $title = null,
        public ?string $gender = null,
        public ?string $key_indicator = null,
        public ?string $maiden_name = null,
        public ?string $org_name = null,
        public ?string $address = null,
        public ?string $address_block = null,
        public ?string $address_city_state = null,
        public ?string $address_post_code = null,
        public ?string $primary_email = null,
        public bool $inactive = false,
    ) {}

    /**
     * @param  ConstituentSearchResultDataResponse  $data
     */
    public static function from(array $data): ConstituentSearchResult
    {
        return new self(
            id: $data['id'],
            lookup_id: $data['lookup_id'] ?? null,
            name: $data['name'] ?? null,
            first_name: $data['first_name'] ?? null,
            last_name: $data['last_name'] ?? null,
            middle_name: $data['middle_name'] ?? null,
            preferred_name: $data['preferred_name'] ?? null,
            former_name: $data['former_name'] ?? null,
            suffix: $data['suffix'] ?? null,
            title: $data['title'] ?? null,
            gender: $data['gender'] ?? null,
            key_indicator: $data['key_indicator'] ?? null,
            maiden_name: $data['maiden_name'] ?? null,
            org_name: $data['org_name'] ?? null,
            address: $data['address'] ?? null,
            address_block: $data['address_block'] ?? null,
            address_city_state: $data['address_city_state'] ?? null,
            address_post_code: $data['address_post_code'] ?? null,
            primary_email: $data['primary_email'] ?? null,
            inactive: $data['inactive'] ?? false,
        );
    }
}
