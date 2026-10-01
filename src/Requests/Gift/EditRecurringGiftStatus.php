<?php

namespace Blackbaud\Requests\Gift;

use Blackbaud\Enums\GiftStatus;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;

class EditRecurringGiftStatus extends Request implements HasBody
{
    use AlwaysThrowOnErrors, HasJsonBody;

    protected Method $method = Method::PUT;

    public function __construct(private readonly int $giftId, private readonly GiftStatus $status) {}

    public function resolveEndpoint(): string
    {
        return "/gift/v1/recurringgifts/{$this->giftId}/status";
    }

    /** @return array{gift_status: string} */
    public function defaultBody(): array
    {
        return ['gift_status' => $this->status->value];
    }
}
