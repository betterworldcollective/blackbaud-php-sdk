<?php

namespace Blackbaud\Requests\Constituent;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;

class CreateConstituentCustomField extends Request implements HasBody
{
    use AlwaysThrowOnErrors, HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  array<string, mixed>  $properties
     *
     * @see ConstituentCustomFieldResource::create()
     */
    public function __construct(protected array $properties) {}

    public function resolveEndpoint(): string
    {
        return '/constituent/v1/constituents/customfields';
    }

    /**
     * @return array<string, mixed>
     */
    public function defaultBody(): array
    {
        return $this->properties;
    }
}
