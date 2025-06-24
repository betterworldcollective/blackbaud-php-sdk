<?php

namespace Blackbaud\Requests\Gift;

use Blackbaud\Data\Gift\Gift;
use JsonException;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;

/**
 * @phpstan-import-type GiftDataResponse from Gift
 */
class GetGift extends Request
{
    use AlwaysThrowOnErrors;

    protected Method $method = Method::GET;

    public function __construct(protected int $id) {}

    public function resolveEndpoint(): string
    {
        return "/gift/v1/gifts/{$this->id}";
    }

    /**
     * @throws JsonException
     */
    public function createDtoFromResponse(Response $response): Gift
    {
        /** @var GiftDataResponse $data */
        $data = $response->json();

        return Gift::from($data);
    }
}
