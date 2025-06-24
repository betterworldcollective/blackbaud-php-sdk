<?php

namespace Blackbaud\Resources;

use Blackbaud\Data\Gift\Gift;
use Blackbaud\Exceptions\InvalidDataException;
use Blackbaud\Requests\Gift\CreateGift;
use Blackbaud\Requests\Gift\GetGift;
use Blackbaud\Requests\Gift\UpdateGift;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\BaseResource;

class GiftResource extends BaseResource
{
    /**
     * @throws FatalRequestException
     * @throws RequestException
     * @throws InvalidDataException
     */
    public function get(int $id): Gift
    {
        $gift = $this->connector->send(new GetGift($id))->dto();

        if (! $gift instanceof Gift) {
            throw new InvalidDataException('Invalid data found.');
        }

        return $gift;
    }

    /**
     * @param  array<string, mixed>  $properties
     * @return int The ID of the newly created gift returned by the API response
     *
     * @throws FatalRequestException
     * @throws RequestException
     *
     * @see https://developer.sky.blackbaud.com/api#api=58bdd5edd7dcde06046081d6&operation=CreateGift List of available properties
     */
    public function create(array $properties): int
    {
        /** @var array{id: string} $response */
        $response = $this->connector->send(new CreateGift($properties))->array();

        return (int) $response['id'];
    }

    /**
     * @param  array<string, mixed>  $properties
     * @return true if the update is successful, otherwise it will throw an exception
     *
     * @throws FatalRequestException
     * @throws RequestException
     *
     * @see https://developer.sky.blackbaud.com/api#api=58bdd5edd7dcde06046081d6&operation=EditGift List of available properties
     */
    public function update(int $id, array $properties): true
    {
        $this->connector->send(new UpdateGift($id, $properties));

        return true;
    }
}
