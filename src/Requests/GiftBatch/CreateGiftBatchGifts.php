<?php

namespace Blackbaud\Requests\GiftBatch;

use Blackbaud\Resources\GiftBatchResource;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;

class CreateGiftBatchGifts extends Request implements HasBody
{
    use AlwaysThrowOnErrors, HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  array<string, mixed>  $properties
     *
     * @see GiftBatchResource::createGifts()
     */
    public function __construct(protected string $batchId, protected array $properties) {}

    public function resolveEndpoint(): string
    {
        return "/gift/v1/giftbatches/{$this->batchId}/gifts";
    }

    /**
     * @return array<string, mixed>
     */
    public function defaultBody(): array
    {
        return $this->properties;
    }
}
