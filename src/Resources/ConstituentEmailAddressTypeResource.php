<?php

namespace Blackbaud\Resources;

use Blackbaud\Data\ApiCollection;
use Blackbaud\Data\Constituent\EmailAddressType;
use Blackbaud\Exceptions\InvalidDataException;
use Blackbaud\Requests\Constituent\GetConstituentEmailAddressTypes;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\BaseResource;

class ConstituentEmailAddressTypeResource extends BaseResource
{
    /**
     * @return ApiCollection<EmailAddressType>
     *
     * @throws RequestException
     * @throws InvalidDataException
     * @throws FatalRequestException
     */
    public function all(): ApiCollection
    {
        $customFields = $this->connector->send(
            new GetConstituentEmailAddressTypes
        )->dto();

        if (! $customFields instanceof ApiCollection) {
            throw new InvalidDataException('Invalid data found.');
        }

        return $customFields;
    }
}
