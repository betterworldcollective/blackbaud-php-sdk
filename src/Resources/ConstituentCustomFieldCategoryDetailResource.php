<?php

namespace Blackbaud\Resources;

use Blackbaud\Data\ApiCollection;
use Blackbaud\Data\Constituent\CustomField;
use Blackbaud\Exceptions\InvalidDataException;
use Blackbaud\Requests\Constituent\GetAllConstituentCustomFieldCategoryDetail;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\BaseResource;

class ConstituentCustomFieldCategoryDetailResource extends BaseResource
{
    /**
     * @return ApiCollection<CustomField>
     *
     * @throws RequestException
     * @throws InvalidDataException
     * @throws FatalRequestException
     */
    public function all(): ApiCollection
    {
        $customFields = $this->connector->send(new GetAllConstituentCustomFieldCategoryDetail)->dto();

        if (! $customFields instanceof ApiCollection) {
            throw new InvalidDataException('Invalid data found.');
        }

        return $customFields;
    }
}
