<?php

namespace Blackbaud\Requests\Fundraising;

use Blackbaud\Data\Fundraiser\Fund;
use JsonException;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;

/**
 * @phpstan-import-type FundDataResponse from Fund
 */
class GetFund extends Request
{
    use AlwaysThrowOnErrors;

    protected Method $method = Method::GET;

    public function __construct(protected int $id) {}

    public function resolveEndpoint(): string
    {
        return "/fundraising/v1/funds/{$this->id}";
    }

    /**
     * @throws JsonException
     */
    public function createDtoFromResponse(Response $response): Fund
    {
        /** @var FundDataResponse $data */
        $data = $response->json();

        return Fund::from($data);
    }
}
