<?php

namespace Blackbaud\Data\Event;

use Blackbaud\Data\BaseData;

/**
 * @phpstan-type AdministrativeAreaResponseData array{
 *     id: string,
 *     name?: string|null,
 *     short_description?: string|null
 * }
 */
class AdministrativeArea extends BaseData
{
    public function __construct(
        public string $id,
        public ?string $name = null,
        public ?string $short_description = null,
    ) {}

    /** @param AdministrativeAreaResponseData $data */
    public static function from(array $data): AdministrativeArea
    {
        return new self(
            id: $data['id'],
            name: $data['name'] ?? null,
            short_description: $data['short_description'] ?? null,
        );
    }
}
