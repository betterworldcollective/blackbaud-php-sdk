<?php

namespace Blackbaud\Data\Constituent;

use Blackbaud\Data\BaseData;

/**
 * @phpstan-type ConstituentSearchResultDataResponse array{
 *     id: string,
 *     address?: string|null,
 *     deceased?: bool,
 *     email?: string|null,
 *     fundraiser_status?: string|null,
 *     inactive?: bool,
 *     lookup_id?: string|null,
 *     name?: string|null,
 *     number_of_subsidiaries?: int|null
 * }
 */
class ConstituentSearchResult extends BaseData
{
    public function __construct(
        public string $id,
        public ?string $address = null,
        public bool $deceased = false,
        public ?string $email = null,
        public ?string $fundraiser_status = null,
        public bool $inactive = false,
        public ?string $lookup_id = null,
        public ?string $name = null,
        public ?int $number_of_subsidiaries = null,
    ) {}

    /**
     * @param  ConstituentSearchResultDataResponse  $data
     */
    public static function from(array $data): ConstituentSearchResult
    {
        return new self(
            id: $data['id'],
            address: $data['address'] ?? null,
            deceased: $data['deceased'] ?? false,
            email: $data['email'] ?? null,
            fundraiser_status: $data['fundraiser_status'] ?? null,
            inactive: $data['inactive'] ?? false,
            lookup_id: $data['lookup_id'] ?? null,
            name: $data['name'] ?? null,
            number_of_subsidiaries: $data['number_of_subsidiaries'] ?? null,
        );
    }
}
