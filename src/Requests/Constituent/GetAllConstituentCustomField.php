<?php

namespace Blackbaud\Requests\Constituent;

use Blackbaud\Data\ApiCollection;
use Blackbaud\Data\CustomField\CustomField;
use Carbon\CarbonImmutable;
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
class GetAllConstituentCustomField extends Request
{
    use AlwaysThrowOnErrors;

    protected Method $method = Method::GET;

    public function __construct(
        protected ?CarbonImmutable $dateAdded,
        protected ?CarbonImmutable $lastModified,
        protected ?string $sortToken,
        protected ?int $limit,
        protected ?int $offset,
        protected bool $includeCount = true,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/constituent/v1/constituents/customfields';
    }

    protected function defaultQuery(): array
    {
        return [
            'date_added' => $this->dateAdded?->toIso8601String(),
            'last_modified' => $this->dateAdded?->toIso8601String(),
            'sort_token' => $this->sortToken,
            'include_count' => var_export($this->includeCount, true),
            'limit' => $this->limit,
            'offset' => $this->offset,
        ];
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
