<?php

namespace Blackbaud\Resources;

use Blackbaud\Data\ApiCollection;
use Blackbaud\Data\CustomField\CustomFieldCategoryDetail;
use Blackbaud\Exceptions\InvalidDataException;
use Blackbaud\Exceptions\QuotaExceededException;
use Blackbaud\Requests\Constituent\GetAllConstituentCustomFieldCategoryDetail;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Exceptions\Request\Statuses\TooManyRequestsException;
use Saloon\Http\BaseResource;

class ConstituentCustomFieldCategoryDetailResource extends BaseResource
{
    /**
     * @return ApiCollection<CustomFieldCategoryDetail>
     *
     * @throws RequestException
     * @throws InvalidDataException
     * @throws FatalRequestException
     * @throws TooManyRequestsException
     * @throws QuotaExceededException
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
