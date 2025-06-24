<?php

namespace BlackbaudSdk\Data\Event;

use BlackbaudSdk\Contracts\Data;
use BlackbaudSdk\Data\BaseData;

/**
 * @phpstan-type LocalityResponseData array{
 *     id: string,
 *     name?: string|null
 * }
 */
class Locality extends BaseData implements Data
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
