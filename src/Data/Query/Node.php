<?php

namespace Blackbaud\Data\Query;

use Blackbaud\Contracts\Data;
use Blackbaud\Data\BaseData;

/**
 * @phpstan-import-type FieldDataResponse from Field
 *
 * @phpstan-type NodeDataResponse array{
 *     id: string,
 *     name?: string|null,
 *     fields?: array<FieldDataResponse>|null,
 * }
 */
class Node extends BaseData implements Data
{
    /**
     * @param  array<Field>  $fields
     */
    public function __construct(
        public string $id,
        public ?string $name = null,
        public ?array $fields = null,
    ) {}

    /**
     * @param  NodeDataResponse  $data
     */
    public static function from(array $data): Node
    {
        return new self(
            id: $data['id'],
            name: $data['name'] ?? null,
            fields: isset($data['fields'])
                ? array_map([Field::class, 'from'], $data['fields'])
                : null,
        );
    }
}
