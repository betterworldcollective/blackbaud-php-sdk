<?php

namespace BlackbaudSdk\Data\Event;

use BlackbaudSdk\Contracts\Data;
use BlackbaudSdk\Data\BaseData;

/**
 * @phpstan-type EventCategoryResponseData array{
 *     id?: string|null,
 *     name?: string|null,
 *     inactive?: bool|null
 * }
 */
class EventCategory extends BaseData implements Data
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
