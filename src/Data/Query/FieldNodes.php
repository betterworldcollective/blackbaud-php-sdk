<?php

namespace Blackbaud\Data\Query;

use Blackbaud\Contracts\Data;
use Blackbaud\Data\BaseData;

/**
 * @phpstan-import-type FieldDataResponse from Field
 * @phpstan-import-type NodeDataResponse from Node
 *
 * @phpstan-type FieldNodesResponse array{
 *     nodes?: array<NodeDataResponse>|null,
 *     fields?: array<FieldDataResponse>|null,
 * }
 */
class FieldNodes extends BaseData implements Data
{
    /**
     * @param  array<Node>  $nodes
     * @param  array<Field>  $fields
     */
    public function __construct(
        public ?array $nodes = null,
        public ?array $fields = null,
    ) {}

    /**
     * @param  FieldNodesResponse  $data
     */
    public static function from(array $data): FieldNodes
    {
        return new self(
            nodes: isset($data['nodes'])
                ? array_map([Node::class, 'from'], $data['nodes'])
                : null,
            fields: isset($data['fields'])
                ? array_map([Field::class, 'from'], $data['fields'])
                : null,
        );
    }
}
