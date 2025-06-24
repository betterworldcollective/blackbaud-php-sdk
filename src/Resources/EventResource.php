<?php

namespace BlackbaudSdk\Resources;

use BlackbaudSdk\Data\Event\Event;
use BlackbaudSdk\Exceptions\InvalidDataException;
use BlackbaudSdk\Requests\Event\CreateEvent;
use BlackbaudSdk\Requests\Event\GetEvent;
use BlackbaudSdk\Requests\Event\UpdateEvent;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\BaseResource;

class EventResource extends BaseResource
{
    /**
     * @throws FatalRequestException
     * @throws RequestException
     * @throws InvalidDataException
     */
    public function get(int $id): Event
    {
        $event = $this->connector->send(new GetEvent($id))->dto();

        if (! $event instanceof Event) {
            throw new InvalidDataException('Invalid data found.');
        }

        return $event;
    }

    /**
     * @param  array<string, mixed>  $properties
     * @return int The ID of the newly created event returned by the API response
     *
     * @throws FatalRequestException
     * @throws RequestException
     *
     * @see https://developer.sky.blackbaud.com/api#api=event&operation=CreateEvent List of available properties
     */
    public function create(array $properties): int
    {
        /** @var array{id: string} $response */
        $response = $this->connector->send(new CreateEvent($properties))->array();

        return (int) $response['id'];
    }

    /**
     * @param  array<string, mixed>  $properties
     * @return true if the update is successful, otherwise it will throw an exception
     *
     * @throws FatalRequestException
     * @throws RequestException
     *
     * @see https://developer.sky.blackbaud.com/api#api=event&operation=EditEvent List of available properties
     */
    public function update(int $id, array $properties): true
    {
        $this->connector->send(new UpdateEvent($id, $properties));

        return true;
    }
}
