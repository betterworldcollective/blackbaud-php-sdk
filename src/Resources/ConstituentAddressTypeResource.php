<?php

namespace Blackbaud\Resources;

use Blackbaud\Data\ApiCollection;
use Blackbaud\Data\Constituent\AddressType;
use Blackbaud\Exceptions\InvalidDataException;
use Blackbaud\Requests\Constituent\GetConstituentAddressTypes;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\BaseResource;

class ConstituentAddressTypeResource extends BaseResource
{
    /**
     * @return ApiCollection<AddressType>
     *
     * @throws RequestException
     * @throws InvalidDataException
     * @throws FatalRequestException
     */
    public function all(): ApiCollection
    {
        $customFields = $this->connector->send(
            new GetConstituentAddressTypes
        )->dto();

        if (! $customFields instanceof ApiCollection) {
            throw new InvalidDataException('Invalid data found.');
        }

        return $customFields;
    }
}
