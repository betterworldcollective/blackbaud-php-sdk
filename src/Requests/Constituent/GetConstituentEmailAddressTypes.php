<?php

namespace Blackbaud\Requests\Constituent;

use Blackbaud\Data\ApiCollection;
use Blackbaud\Data\Constituent\EmailAddressType;
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
class GetConstituentEmailAddressTypes extends Request
{
    use AlwaysThrowOnErrors;

    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/constituent/v1/emailaddresstypes';
    }

    /**
     * @return ApiCollection<EmailAddressType>
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

        return ApiCollection::from($data['value'], EmailAddressType::class, $data['count'] ?? null);
    }
}
