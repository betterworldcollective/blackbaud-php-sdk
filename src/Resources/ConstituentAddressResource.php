<?php

namespace Blackbaud\Resources;

use Blackbaud\Data\ApiCollection;
use Blackbaud\Data\Constituent\Address;
use Blackbaud\Exceptions\BadRequestException;
use Blackbaud\Exceptions\InvalidDataException;
use Blackbaud\Exceptions\UnauthorizedException;
use Blackbaud\Requests\Constituent\CreateConstituentAddress;
use Blackbaud\Requests\Constituent\ListConstituentAddresses;
use Blackbaud\Requests\Constituent\UpdateConstituentAddress;
use Saloon\Http\BaseResource;

class ConstituentAddressResource extends BaseResource
{
    /**
     * @return ApiCollection<Address>
     *
     * @throws BadRequestException
     * @throws InvalidDataException
     * @throws UnauthorizedException
     *
     * @see https://developer.sky.blackbaud.com/api#api=56b76470069a0509c8f1c5b3&operation=ListConstituentAddressesByConstituent
     */
    public function list(int $constituentId): ApiCollection
    {
        $addresses = $this->connector->send(
            new ListConstituentAddresses($constituentId)
        )->dto();

        if (! $addresses instanceof ApiCollection) {
            throw new InvalidDataException('Invalid data found.');
        }

        return $addresses;
    }

    /**
     * @param  array<string, mixed>  $properties
     * @return int The ID of the newly created constituent address returned by the API response
     *
     * @throws BadRequestException
     * @throws UnauthorizedException
     *
     * @see https://developer.sky.blackbaud.com/api#api=56b76470069a0509c8f1c5b3&operation=CreateConstituentAddress List of available properties
     */
    public function create(array $properties): int
    {
        /** @var array{id: string} $response */
        $response = $this->connector->send(new CreateConstituentAddress($properties))->array();

        return (int) $response['id'];
    }

    /**
     * @param  array<string, mixed>  $properties
     * @return true if the update is successful, otherwise it will throw an exception
     *
     * @throws BadRequestException
     * @throws UnauthorizedException
     *
     * @see https://developer.sky.blackbaud.com/api#api=56b76470069a0509c8f1c5b3&operation=EditConstituentAddress List of available properties
     */
    public function update(int $id, array $properties): true
    {
        $this->connector->send(new UpdateConstituentAddress($id, $properties));

        return true;
    }
}
