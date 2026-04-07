<?php

namespace Blackbaud\Requests\Constituent;

use Blackbaud\Data\ApiCollection;
use Blackbaud\Data\Constituent\Address;
use Blackbaud\Resources\ConstituentAddressResource;
use JsonException;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;

/**
 * @phpstan-import-type AddressDataResponse from Address
 *
 * @phpstan-type ApiCollectionResponse array{
 *     count: ?int,
 *     next_link: ?string,
 *     value: array<AddressDataResponse>
 * }
 *
 * @see ConstituentAddressResource::list()
 */
class ListConstituentAddresses extends Request
{
    use AlwaysThrowOnErrors;

    protected Method $method = Method::GET;

    public function __construct(protected int $constituentId) {}

    public function resolveEndpoint(): string
    {
        return "/constituent/v1/constituents/{$this->constituentId}/addresses";
    }

    /**
     * @return ApiCollection<Address>
     *
     * @throws JsonException
     */
    public function createDtoFromResponse(Response $response): ApiCollection
    {
        /** @var ApiCollectionResponse $data */
        $data = $response->json();

        return ApiCollection::from($data['value'], Address::class, $data['count'] ?? null, $data['next_link'] ?? null);
    }
}
