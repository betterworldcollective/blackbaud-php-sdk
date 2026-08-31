<?php

namespace Blackbaud\Resources;

use Blackbaud\Data\ApiCollection;
use Blackbaud\Data\Constituent\AddressType;
use Blackbaud\Exceptions\InvalidDataException;
use Blackbaud\Exceptions\QuotaExceededException;
use Blackbaud\Requests\Constituent\GetConstituentAddressTypes;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Exceptions\Request\Statuses\TooManyRequestsException;
use Saloon\Http\BaseResource;

class ConstituentAddressTypeResource extends BaseResource
{
    /**
     * @return ApiCollection<AddressType>
     *
     * @throws RequestException
     * @throws InvalidDataException
     * @throws FatalRequestException
     * @throws TooManyRequestsException
     * @throws QuotaExceededException
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
