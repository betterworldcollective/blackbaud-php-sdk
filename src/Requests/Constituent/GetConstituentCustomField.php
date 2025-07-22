<?php

namespace Blackbaud\Requests\Constituent;

use Blackbaud\Data\ApiCollection;
use Blackbaud\Data\Constituent\CustomField;
use JsonException;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;

/**
 * @phpstan-import-type CustomFieldDataResponse from CustomField
 *
 * @phpstan-type ApiCollectionResponse array{
 *     count: ?int,
 *     next_link: ?string,
 *     value: array<CustomFieldDataResponse>
 * }
 */
class GetConstituentCustomField extends Request
{
    use AlwaysThrowOnErrors;

    protected Method $method = Method::GET;

    public function __construct(protected int $id) {}

    public function resolveEndpoint(): string
    {
        return "/constituent/v1/constituents/{$this->id}/customfields";
    }

    /**
     * @return ApiCollection<CustomField>
     *
     * @throws JsonException
     */
    public function createDtoFromResponse(Response $response): ApiCollection
    {
        /** @var ApiCollectionResponse $data */
        $data = $response->json();

        return ApiCollection::from($data['value'], CustomField::class, $data['count'] ?? null, $data['next_link'] ?? null);
    }
}
