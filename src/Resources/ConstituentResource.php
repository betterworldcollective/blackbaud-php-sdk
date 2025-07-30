<?php

namespace Blackbaud\Resources;

use Blackbaud\Data\Constituent\Constituent;
use Blackbaud\Exceptions\BadRequestException;
use Blackbaud\Exceptions\InvalidDataException;
use Blackbaud\Exceptions\ObjectNotFoundException;
use Blackbaud\Exceptions\UnauthorizedException;
use Blackbaud\Requests\Constituent\CreateConstituent;
use Blackbaud\Requests\Constituent\GetConstituent;
use Blackbaud\Requests\Constituent\UpdateConstituent;
use Saloon\Http\BaseResource;

class ConstituentResource extends BaseResource
{
    /**
     * @throws ObjectNotFoundException
     * @throws UnauthorizedException
     * @throws InvalidDataException
     */
    public function get(int $id): Constituent
    {
        $constituent = $this->connector->send(new GetConstituent($id))->dto();

        if (! $constituent instanceof Constituent) {
            throw new InvalidDataException('Invalid data found.');
        }

        return $constituent;
    }

    /**
     * @param  array<string, mixed>  $properties
     * @return int The ID of the newly created constituent returned by the API response
     *
     * @throws BadRequestException
     * @throws UnauthorizedException
     *
     * @see https://developer.sky.blackbaud.com/api#api=56b76470069a0509c8f1c5b3&operation=CreateConstituent List of available properties
     */
    public function create(array $properties): int
    {
        /** @var array{id: string} $response */
        $response = $this->connector->send(new CreateConstituent($properties))->array();

        return (int) $response['id'];
    }

    /**
     * @param  array<string, mixed>  $properties
     * @return true if the update is successful, otherwise it will throw an exception
     *
     * @throws BadRequestException
     * @throws UnauthorizedException
     *
     * @see https://developer.sky.blackbaud.com/api#api=56b76470069a0509c8f1c5b3&operation=EditConstituent List of available properties
     */
    public function update(int $id, array $properties): true
    {
        $this->connector->send(new UpdateConstituent($id, $properties));

        return true;
    }
}
