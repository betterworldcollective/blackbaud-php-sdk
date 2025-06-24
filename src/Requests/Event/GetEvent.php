<?php

namespace BlackbaudSdk\Requests\Event;

use BlackbaudSdk\Data\Event\Event;
use JsonException;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;

/**
 * @phpstan-import-type EventDataResponse from Event
 */
class GetEvent extends Request
{
    use AlwaysThrowOnErrors;

    protected Method $method = Method::GET;

    public function __construct(protected int $id) {}

    public function resolveEndpoint(): string
    {
        return "/event/v1/events/{$this->id}";
    }

    /**
     * @throws JsonException
     */
    public function createDtoFromResponse(Response $response): Event
    {
        /** @var EventDataResponse $data */
        $data = $response->json();

        return Event::from($data);
    }
}
