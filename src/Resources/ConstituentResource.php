<?php

namespace BlackbaudSdk\Resources;

use BlackbaudSdk\Data\Constituent\Constituent;
use BlackbaudSdk\Exceptions\InvalidDataException;
use BlackbaudSdk\Requests\Constituent\CreateConstituent;
use BlackbaudSdk\Requests\Constituent\GetConstituent;
use BlackbaudSdk\Requests\Constituent\UpdateConstituent;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\BaseResource;

class ConstituentResource extends BaseResource
{
    /**
     * @throws FatalRequestException
     * @throws RequestException
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
     * @throws FatalRequestException
     * @throws RequestException
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
     * @throws FatalRequestException
     * @throws RequestException
     *
     * @see https://developer.sky.blackbaud.com/api#api=56b76470069a0509c8f1c5b3&operation=EditConstituent List of available properties
     */
    public function update(int $id, array $properties): true
    {
        $this->connector->send(new UpdateConstituent($id, $properties));

        return true;
    }
}
