<?php

namespace Blackbaud\Data\Constituent;

use Blackbaud\Contracts\Data;
use Blackbaud\Data\BaseData;

/**
 * @phpstan-type SpouseDataResponse array{
 *     id: string,
 *     first?: string|null,
 *     last?: string|null,
 *     is_head_of_household: bool
 * }
 */
class Spouse extends BaseData implements Data
{
    public function __construct(
        public string $id,
        public ?string $first = null,
        public ?string $last = null,
        public bool $is_head_of_household = false,
    ) {}

    /**
     * @param  SpouseDataResponse  $data
     */
    public static function from(array $data): Spouse
    {
        return new self(
            id: $data['id'],
            first: $data['first'] ?? null,
            last: $data['last'] ?? null,
            is_head_of_household: $data['is_head_of_household']
        );
    }
}
