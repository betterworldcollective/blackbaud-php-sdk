<?php

namespace BlackbaudSdk\Data\Event;

use BlackbaudSdk\Contracts\Data;
use BlackbaudSdk\Data\BaseData;

/**
 * @phpstan-type SubAdministrativeAreaResponseData array{
 *     id: string,
 *     name?: string|null
 * }
 */
class SubAdministrativeArea extends BaseData implements Data
{
    public function __construct(
        public string $id,
        public ?string $name = null,
    ) {}

    /** @param SubAdministrativeAreaResponseData $data */
    public static function from(array $data): SubAdministrativeArea
    {
        return new self(
            id: $data['id'],
            name: $data['name'] ?? null,
        );
    }
}
