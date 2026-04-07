<?php

namespace Blackbaud\Resources;

use Blackbaud\Data\ApiCollection;
use Blackbaud\Data\Constituent\Phone;
use Blackbaud\Exceptions\BadRequestException;
use Blackbaud\Exceptions\InvalidDataException;
use Blackbaud\Exceptions\UnauthorizedException;
use Blackbaud\Requests\Constituent\CreateConstituentPhone;
use Blackbaud\Requests\Constituent\ListConstituentPhones;
use Blackbaud\Requests\Constituent\UpdateConstituentPhone;
use Saloon\Http\BaseResource;

class ConstituentPhoneResource extends BaseResource
{
    /**
     * @return ApiCollection<Phone>
     *
     * @throws BadRequestException
     * @throws InvalidDataException
     * @throws UnauthorizedException
     *
     * @see https://developer.sky.blackbaud.com/api#api=56b76470069a0509c8f1c5b3&operation=ListConstituentPhonesByConstituent
     */
    public function list(int $constituentId): ApiCollection
    {
        $phones = $this->connector->send(
            new ListConstituentPhones($constituentId)
        )->dto();

        if (! $phones instanceof ApiCollection) {
            throw new InvalidDataException('Invalid data found.');
        }

        return $phones;
    }

    /**
     * @param  array<string, mixed>  $properties
     * @return int The ID of the newly created constituent phone returned by the API response
     *
     * @throws BadRequestException
     * @throws UnauthorizedException
     *
     * @see https://developer.sky.blackbaud.com/api#api=56b76470069a0509c8f1c5b3&operation=CreateConstituentPhone List of available properties
     */
    public function create(array $properties): int
    {
        /** @var array{id: string} $response */
        $response = $this->connector->send(new CreateConstituentPhone($properties))->array();

        return (int) $response['id'];
    }

    /**
     * @param  array<string, mixed>  $properties
     * @return true if the update is successful, otherwise it will throw an exception
     *
     * @throws BadRequestException
     * @throws UnauthorizedException
     *
     * @see https://developer.sky.blackbaud.com/api#api=56b76470069a0509c8f1c5b3&operation=EditConstituentPhone List of available properties
     */
    public function update(int $id, array $properties): true
    {
        $this->connector->send(new UpdateConstituentPhone($id, $properties));

        return true;
    }
}
