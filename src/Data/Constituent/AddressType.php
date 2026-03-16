<?php

namespace Blackbaud\Data\Constituent;

use Blackbaud\Data\BaseData;

/**
 * @phpstan-type AddressTypeResponse array{
 *      name: string,
 *  }
 */
class AddressType extends BaseData
{
    public function __construct(
        public string $name,
    ) {}

    /**
     * @param  AddressTypeResponse  $data
     */
    public static function from(array $data): AddressType
    {
        return new self(
            name: $data['name'],
        );
    }
}
