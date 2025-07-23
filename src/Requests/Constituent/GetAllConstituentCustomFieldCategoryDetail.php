<?php

namespace Blackbaud\Requests\Constituent;

use Blackbaud\Data\ApiCollection;
use Blackbaud\Data\CustomField\CustomFieldCategoryDetail;
use JsonException;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;

/**
 * @phpstan-import-type CustomFieldCategoryDetailResponseData from CustomFieldCategoryDetail
 *
 * @phpstan-type ApiCollectionResponse array{
 *     count: ?int,
 *     next_link: ?string,
 *     value: array<CustomFieldCategoryDetailResponseData>
 * }
 */
class GetAllConstituentCustomFieldCategoryDetail extends Request
{
    use AlwaysThrowOnErrors;

    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/constituent/v1/constituents/customfields/categories/details';
    }

    /**
     * @return ApiCollection<CustomFieldCategoryDetail>
     *
     * @throws JsonException
     */
    public function createDtoFromResponse(Response $response): ApiCollection
    {
        /** @var ApiCollectionResponse $data */
        $data = $response->json();

        return ApiCollection::from($data['value'], CustomFieldCategoryDetail::class, $data['count'] ?? null, $data['next_link'] ?? null);
    }
}
