<?php

namespace Blackbaud\Data\Constituent;

use Blackbaud\Data\BaseData;

/**
 * @phpstan-type EmailTypeResponse array{
 *      name: string,
 *  }
 */
class EmailAddressType extends BaseData
{
    public function __construct(
        public string $name,
    ) {}

    /**
     * @param  EmailTypeResponse  $data
     */
    public static function from(array $data): EmailAddressType
    {
        return new self(
            name: $data['name'],
        );
    }
}
