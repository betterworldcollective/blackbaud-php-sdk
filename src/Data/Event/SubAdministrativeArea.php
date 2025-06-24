<?php

namespace Blackbaud\Data\Event;

use Blackbaud\Contracts\Data;
use Blackbaud\Data\BaseData;

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
