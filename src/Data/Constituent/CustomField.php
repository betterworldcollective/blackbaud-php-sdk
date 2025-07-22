<?php

namespace Blackbaud\Data\Constituent;

use Blackbaud\Contracts\Data;
use Blackbaud\Data\BaseData;
use Carbon\CarbonImmutable;

/**
 * @phpstan-type CustomFieldDataResponse array{
 *     id: string,
 *     category: string,
 *     comment?: string|null,
 *     date?: string|null,
 *     date_added?: string|null,
 *     date_modified?: string|null,
 *     parent_id?: string|null,
 *     type?: string|null,
 *     value?: string
 * }
 */
class CustomField extends BaseData implements Data
{
    public function __construct(
        public string $id,
        public string $category,
        public ?string $comment = null,
        public ?CarbonImmutable $date = null,
        public ?CarbonImmutable $date_added = null,
        public ?CarbonImmutable $date_modified = null,
        public ?string $parent_id = null,
        public ?string $type = null,
        public mixed $value = null,
    ) {}

    /** @param CustomFieldDataResponse $data */
    public static function from(array $data): CustomField
    {
        /** @var ?string $date */
        $date = data_get($data, 'date');

        /** @var ?string $dateAdded */
        $dateAdded = data_get($data, 'date_added');

        /** @var ?string $dateModified */
        $dateModified = data_get($data, 'date_modified');

        return new self(
            id: $data['id'],
            category: $data['category'],
            comment: $data['comment'] ?? null,
            date: $date ? CarbonImmutable::parse($date) : null,
            date_added: $dateAdded ? CarbonImmutable::parse($dateAdded) : null,
            date_modified: $dateModified ? CarbonImmutable::parse($dateModified) : null,
            parent_id: $data['parent_id'] ?? null,
            type: $data['type'] ?? null,
            value: $data['value'] ?? null,
        );
    }
}
