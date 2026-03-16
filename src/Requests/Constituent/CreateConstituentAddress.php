<?php

namespace Blackbaud\Requests\Constituent;

use Blackbaud\Resources\ConstituentAddressResource;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;

class CreateConstituentAddress extends Request implements HasBody
{
    use AlwaysThrowOnErrors, HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  array<string, mixed>  $properties
     *
     * @see ConstituentAddressResource::create()
     */
    public function __construct(protected array $properties) {}

    public function resolveEndpoint(): string
    {
        return '/constituent/v1/addresses';
    }

    /**
     * @return array<string, mixed>
     */
    public function defaultBody(): array
    {
        return $this->properties;
    }
}
