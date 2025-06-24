<?php

namespace BlackbaudSdk\Data\Constituent;

use BlackbaudSdk\Contracts\Data;
use BlackbaudSdk\Data\BaseData;
use Carbon\CarbonImmutable;

/**
 * @phpstan-type OnlinePresenceDataResponse array{
 *     id: string,
 *     address: string,
 *     constituent_id?: string|null,
 *     type?: string|null,
 *     inactive: bool,
 *     primary: bool,
 *     date_added?: string|null,
 *     date_modified?: string|null
 * }
 */
class OnlinePresence extends BaseData implements Data
{
    public function __construct(
        public string $id,
        public string $address,
        public ?string $constituent_id = null,
        public ?string $type = null,
        public bool $inactive = false,
        public bool $primary = false,
        public ?CarbonImmutable $date_added = null,
        public ?CarbonImmutable $date_modified = null,
    ) {}

    /**
     * @param  OnlinePresenceDataResponse  $data
     */
    public static function from(array $data): OnlinePresence
    {
        /** @var ?string $dateAdded */
        $dateAdded = data_get($data, 'date_added');

        /** @var ?string $dateModified */
        $dateModified = data_get($data, 'date_modified');

        return new self(
            id: $data['id'],
            address: $data['address'],
            constituent_id: $data['constituent_id'] ?? null,
            type: $data['type'] ?? null,
            inactive: $data['inactive'],
            primary: $data['primary'],
            date_added: $dateAdded
                ? CarbonImmutable::parse($dateAdded)
                : null,
            date_modified: $dateModified
                ? CarbonImmutable::parse($dateModified)
                : null,
        );
    }
}
