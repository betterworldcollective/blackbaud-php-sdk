<?php

namespace Blackbaud\Requests\Fundraising;

use Blackbaud\Data\Fundraiser\Appeal;
use JsonException;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;

/**
 * @phpstan-import-type AppealDataResponse from Appeal
 */
class GetAppeal extends Request
{
    use AlwaysThrowOnErrors;

    protected Method $method = Method::GET;

    public function __construct(protected int $id) {}

    public function resolveEndpoint(): string
    {
        return "/fundraising/v1/appeals/{$this->id}";
    }

    /**
     * @throws JsonException
     */
    public function createDtoFromResponse(Response $response): Appeal
    {
        /** @var AppealDataResponse $data */
        $data = $response->json();

        return Appeal::from($data);
    }
}
