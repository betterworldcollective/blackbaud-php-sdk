<?php

namespace Blackbaud\Requests\Fundraising;

use Blackbaud\Data\Fundraiser\Package;
use JsonException;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;

/**
 * @phpstan-import-type PackageDataResponse from Package
 */
class GetPackage extends Request
{
    use AlwaysThrowOnErrors;

    protected Method $method = Method::GET;

    public function __construct(protected int $id) {}

    public function resolveEndpoint(): string
    {
        return "/fundraising/v1/packages/{$this->id}";
    }

    /**
     * @throws JsonException
     */
    public function createDtoFromResponse(Response $response): Package
    {
        /** @var PackageDataResponse $data */
        $data = $response->json();

        return Package::from($data);
    }
}
