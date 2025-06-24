<?php

namespace Blackbaud\Requests\Event;

use Blackbaud\Resources\EventResource;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;

class UpdateEvent extends Request implements HasBody
{
    use AlwaysThrowOnErrors, HasJsonBody;

    protected Method $method = Method::PATCH;

    /**
     * @param  array<string, mixed>  $properties
     *
     * @see EventResource::update()
     */
    public function __construct(protected int $id, protected array $properties) {}

    public function resolveEndpoint(): string
    {
        return "/event/v1/events/{$this->id}";
    }

    /**
     * @return array<string, mixed>
     */
    public function defaultBody(): array
    {
        return $this->properties;
    }
}
