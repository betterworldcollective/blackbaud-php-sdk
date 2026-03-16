<?php

namespace Blackbaud\Resources;

use Blackbaud\Data\ApiCollection;
use Blackbaud\Data\Constituent\PhoneType;
use Blackbaud\Exceptions\InvalidDataException;
use Blackbaud\Requests\Constituent\GetConstituentPhoneTypes;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\BaseResource;

class ConstituentPhoneTypeResource extends BaseResource
{
    /**
     * @return ApiCollection<PhoneType>
     *
     * @throws RequestException
     * @throws InvalidDataException
     * @throws FatalRequestException
     */
    public function all(): ApiCollection
    {
        $customFields = $this->connector->send(
            new GetConstituentPhoneTypes
        )->dto();

        if (! $customFields instanceof ApiCollection) {
            throw new InvalidDataException('Invalid data found.');
        }

        return $customFields;
    }
}
