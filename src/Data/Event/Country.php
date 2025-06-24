<?php

namespace BlackbaudSdk\Data\Event;

use BlackbaudSdk\Contracts\Data;
use BlackbaudSdk\Data\BaseData;

/**
 * @phpstan-type CountryResponseData array{
 *     id: string,
 *     display_name?: string|null,
 *     iso_alpha2_code?: string|null
 * }
 */
class Country extends BaseData implements Data
{
    public function __construct(
        public string $id,
        public ?string $display_name = null,
        public ?string $iso_alpha2_code = null,
    ) {}

    /** @param CountryResponseData $data */
    public static function from(array $data): Country
    {
        return new self(
            id: $data['id'],
            display_name: $data['display_name'] ?? null,
            iso_alpha2_code: $data['iso_alpha2_code'] ?? null,
        );
    }
}
