<?php

namespace Blackbaud\Requests\Constituent;

use Blackbaud\Resources\ConstituentAddressResource;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;

class UpdateConstituentAddress extends Request implements HasBody
{
    use AlwaysThrowOnErrors, HasJsonBody;

    protected Method $method = Method::PATCH;

    /**
     * @param  array<string, mixed>  $properties
     *
     * @see ConstituentAddressResource::update()
     */
    public function __construct(protected int $id, protected array $properties) {}

    public function resolveEndpoint(): string
    {
        return "/constituent/v1/addresses/{$this->id}";
    }

    /**
     * @return array<string, mixed>
     */
    public function defaultBody(): array
    {
        return $this->properties;
    }
}
