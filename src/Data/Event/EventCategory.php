<?php

namespace Blackbaud\Data\Event;

use Blackbaud\Data\BaseData;

/**
 * @phpstan-type EventCategoryResponseData array{
 *     id?: string|null,
 *     name?: string|null,
 *     inactive?: bool|null
 * }
 */
class EventCategory extends BaseData
{
    public function __construct(
        public ?string $id = null,
        public ?string $name = null,
        public ?bool $inactive = null,
    ) {}

    /** @param EventCategoryResponseData $data */
    public static function from(array $data): EventCategory
    {
        return new self(
            id: $data['id'] ?? null,
            name: $data['name'] ?? null,
            inactive: $data['inactive'] ?? null,
        );
    }
}
