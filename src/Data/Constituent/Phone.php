<?php

namespace BlackbaudSdk\Data\Constituent;

use BlackbaudSdk\Contracts\Data;
use BlackbaudSdk\Data\BaseData;
use Carbon\CarbonImmutable;

/**
 * @phpstan-type PhoneDataResponse array{
 *     id: string,
 *     number: string,
 *     type?: string|null,
 *     constituent_id?: string|null,
 *     do_not_call: bool,
 *     inactive: bool,
 *     primary: bool,
 *     date_added?: string|null,
 *     date_modified?: string|null
 * }
 */
class Phone extends BaseData implements Data
{
    public function __construct(
        public string $id,
        public string $number,
        public ?string $type = null,
        public ?string $constituent_id = null,
        public bool $do_not_call = false,
        public bool $inactive = false,
        public bool $primary = false,
        public ?CarbonImmutable $date_added = null,
        public ?CarbonImmutable $date_modified = null,
    ) {}

    /**
     * @param  PhoneDataResponse  $data
     */
    public static function from(array $data): Phone
    {
        /** @var ?string $dateAdded */
        $dateAdded = data_get($data, 'date_added');

        /** @var ?string $dateModified */
        $dateModified = data_get($data, 'date_modified');

        return new self(
            id: $data['id'],
            number: $data['number'],
            type: $data['type'] ?? null,
            constituent_id: $data['constituent_id'] ?? null,
            inactive: $data['inactive'],
            primary: $data['primary'],
            date_added: $dateAdded
                ? CarbonImmutable::parse($dateAdded)
                : null,
            date_modified: $dateModified
                ? CarbonImmutable::parse($dateModified)
                : null
        );
    }
}
