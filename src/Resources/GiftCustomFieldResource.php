<?php

namespace Blackbaud\Resources;

use Blackbaud\Data\ApiCollection;
use Blackbaud\Data\CustomField\CustomField;
use Blackbaud\Exceptions\InvalidDataException;
use Blackbaud\Requests\Gift\CreateGiftCustomField;
use Blackbaud\Requests\Gift\GetGiftCustomField;
use Blackbaud\Requests\Gift\UpdateGiftCustomField;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\BaseResource;

class GiftCustomFieldResource extends BaseResource
{
    /**
     * @return ApiCollection<CustomField>
     *
     * @throws FatalRequestException
     * @throws RequestException
     * @throws InvalidDataException
     */
    public function get(int $id): ApiCollection
    {
        $customFields = $this->connector->send(new GetGiftCustomField($id))->dto();

        if (! $customFields instanceof ApiCollection) {
            throw new InvalidDataException('Invalid data found.');
        }

        return $customFields;
    }

    /**
     * @param  array<string, mixed>  $properties
     * @return int The ID of the newly created constituent custom form returned by the API response
     *
     * @throws FatalRequestException
     * @throws RequestException
     *
     * @see https://developer.sky.blackbaud.com/api#api=58bdd5edd7dcde06046081d6&operation=CreateGiftCustomField List of available properties
     */
    public function create(array $properties): int
    {
        /** @var array{id: string} $response */
        $response = $this->connector->send(new CreateGiftCustomField($properties))->array();

        return (int) $response['id'];
    }

    /**
     * @param  array<string, mixed>  $properties
     * @return true if the update is successful, otherwise it will throw an exception
     *
     * @throws FatalRequestException
     * @throws RequestException
     *
     * @see https://developer.sky.blackbaud.com/api#api=58bdd5edd7dcde06046081d6&operation=EditGiftCustomField List of available properties
     */
    public function update(int $id, array $properties): true
    {
        $this->connector->send(new UpdateGiftCustomField($id, $properties));

        return true;
    }
}
