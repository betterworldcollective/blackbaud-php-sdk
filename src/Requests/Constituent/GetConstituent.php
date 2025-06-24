<?php

namespace Blackbaud\Requests\Constituent;

use Blackbaud\Data\Constituent\Constituent;
use JsonException;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;

/**
 * @phpstan-import-type ConstituentDataResponse from Constituent
 */
class GetConstituent extends Request
{
    use AlwaysThrowOnErrors;

    protected Method $method = Method::GET;

    public function __construct(protected int $id) {}

    public function resolveEndpoint(): string
    {
        return "/constituent/v1/constituents/{$this->id}";
    }

    /**
     * @throws JsonException
     */
    public function createDtoFromResponse(Response $response): Constituent
    {
        /** @var ConstituentDataResponse $data */
        $data = $response->json();

        return Constituent::from($data);
    }
}
