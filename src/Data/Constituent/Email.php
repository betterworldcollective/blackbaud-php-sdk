<?php

namespace Blackbaud\Data\Constituent;

use Blackbaud\Contracts\Data;
use Blackbaud\Data\BaseData;
use Carbon\CarbonImmutable;

/**
 * @phpstan-type EmailDataResponse array{
 *     id: string,
 *     address: string,
 *     constituent_id?: string|null,
 *     type?: string|null,
 *     do_not_email: bool,
 *     inactive: bool,
 *     primary: bool,
 *     date_added?: string|null,
 *     date_modified?: string|null
 * }
 */
class Email extends BaseData implements Data
{
    public function __construct(
        public string $id,
        public string $address,
        public ?string $constituent_id = null,
        public ?string $type = null,
        public bool $do_not_email = false,
        public bool $inactive = false,
        public bool $primary = false,
        public ?CarbonImmutable $date_added = null,
        public ?CarbonImmutable $date_modified = null,
    ) {}

    /**
     * @param  EmailDataResponse  $data
     */
    public static function from(array $data): Email
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
            do_not_email: $data['do_not_email'],
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
