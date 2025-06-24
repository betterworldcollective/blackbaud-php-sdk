<?php

namespace BlackbaudSdk\Requests\Constituent;

use BlackbaudSdk\Resources\ConstituentResource;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;

class CreateConstituent extends Request implements HasBody
{
    use AlwaysThrowOnErrors, HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  array<string, mixed>  $properties
     *
     * @see ConstituentResource::create()
     */
    public function __construct(protected array $properties) {}

    public function resolveEndpoint(): string
    {
        return '/constituent/v1/constituents';
    }

    /**
     * @return array<string, mixed>
     */
    public function defaultBody(): array
    {
        return $this->properties;
    }
}
