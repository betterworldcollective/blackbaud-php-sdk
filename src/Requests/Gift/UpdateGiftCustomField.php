<?php

namespace Blackbaud\Requests\Gift;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;

class UpdateGiftCustomField extends Request implements HasBody
{
    use AlwaysThrowOnErrors, HasJsonBody;

    protected Method $method = Method::PATCH;

    /**
     * @param  array<string, mixed>  $properties
     *
     * @see GiftCustomFieldResource::update()
     */
    public function __construct(protected int $id, protected array $properties) {}

    public function resolveEndpoint(): string
    {
        return "/gift/v1/gifts/customfields/{$this->id}";
    }

    /**
     * @return array<string, mixed>
     */
    public function defaultBody(): array
    {
        return $this->properties;
    }
}
