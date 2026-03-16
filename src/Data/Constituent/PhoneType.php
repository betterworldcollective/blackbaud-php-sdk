<?php

namespace Blackbaud\Data\Constituent;

use Blackbaud\Data\BaseData;

/**
 * @phpstan-type PhoneTypeResponse array{
 *      name: string,
 *  }
 */
class PhoneType extends BaseData
{
    public function __construct(
        public string $name,
    ) {}

    /**
     * @param  PhoneTypeResponse  $data
     */
    public static function from(array $data): PhoneType
    {
        return new self(
            name: $data['name'],
        );
    }
}
