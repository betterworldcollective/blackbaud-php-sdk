<?php

namespace Blackbaud\Data\Event;

use Blackbaud\Data\BaseData;

/**
 * @phpstan-type LocalityResponseData array{
 *     id: string,
 *     name?: string|null
 * }
 */
class Locality extends BaseData
{
    public function __construct(
        public string $id,
        public ?string $name = null,
    ) {}

    /** @param LocalityResponseData $data */
    public static function from(array $data): Locality
    {
        return new self(
            id: $data['id'],
            name: $data['name'] ?? null,
        );
    }
}
