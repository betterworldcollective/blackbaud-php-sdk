<?php

namespace Blackbaud\Requests\GiftBatch;

use Blackbaud\Resources\GiftBatchResource;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;

class CreateGiftBatch extends Request implements HasBody
{
    use AlwaysThrowOnErrors, HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  array<string, mixed>  $properties
     *
     * @see GiftBatchResource::create()
     */
    public function __construct(protected array $properties) {}

    public function resolveEndpoint(): string
    {
        return '/gift-batch/v1/giftbatches';
    }

    /**
     * @return array<string, mixed>
     */
    public function defaultBody(): array
    {
        return $this->properties;
    }
}
