<?php

namespace Blackbaud\Requests\Constituent;

use Blackbaud\Data\ApiCollection;
use Blackbaud\Data\Constituent\AddressType;
use JsonException;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;

/**
 * @phpstan-type ApiCollectionResponse array{
 *      count: ?int,
 *      value: array<string>
 *  }
 */
class GetConstituentAddressTypes extends Request
{
    use AlwaysThrowOnErrors;

    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/constituent/v1/addresstypes';
    }

    /**
     * @return ApiCollection<AddressType>
     *
     * @throws JsonException
     */
    public function createDtoFromResponse(Response $response): ApiCollection
    {
        /** @var ApiCollectionResponse $data */
        $data = $response->json();

        $data['value'] = array_map(fn (string $value) => [
            'name' => $value,
        ], $data['value']);

        return ApiCollection::from($data['value'], AddressType::class, $data['count'] ?? null);
    }
}
