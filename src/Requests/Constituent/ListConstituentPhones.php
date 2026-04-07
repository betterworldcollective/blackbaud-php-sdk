<?php

namespace Blackbaud\Requests\Constituent;

use Blackbaud\Data\ApiCollection;
use Blackbaud\Data\Constituent\Phone;
use Blackbaud\Resources\ConstituentPhoneResource;
use JsonException;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;

/**
 * @phpstan-import-type PhoneDataResponse from Phone
 *
 * @phpstan-type ApiCollectionResponse array{
 *     count: ?int,
 *     next_link: ?string,
 *     value: array<PhoneDataResponse>
 * }
 *
 * @see ConstituentPhoneResource::list()
 */
class ListConstituentPhones extends Request
{
    use AlwaysThrowOnErrors;

    protected Method $method = Method::GET;

    public function __construct(protected int $constituentId) {}

    public function resolveEndpoint(): string
    {
        return "/constituent/v1/constituents/{$this->constituentId}/phones";
    }

    /**
     * @return ApiCollection<Phone>
     *
     * @throws JsonException
     */
    public function createDtoFromResponse(Response $response): ApiCollection
    {
        /** @var ApiCollectionResponse $data */
        $data = $response->json();

        return ApiCollection::from($data['value'], Phone::class, $data['count'] ?? null, $data['next_link'] ?? null);
    }
}
