<?php

namespace Blackbaud\Data\Event;

use Blackbaud\Contracts\Data;
use Blackbaud\Data\BaseData;

/**
 * @phpstan-type EventGroupResponseData array{
 *     id?: string|null,
 *     name?: string|null,
 *     is_inactive?: bool|null
 * }
 */
class EventGroup extends BaseData implements Data
{
    public function __construct(
        public ?string $id = null,
        public ?string $name = null,
        public ?bool $is_inactive = null,
    ) {}

    /** @param EventGroupResponseData $data */
    public static function from(array $data): EventGroup
    {
        return new self(
            id: $data['id'] ?? null,
            name: $data['name'] ?? null,
            is_inactive: $data['is_inactive'] ?? null,
        );
    }
}
