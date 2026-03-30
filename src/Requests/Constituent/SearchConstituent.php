<?php

namespace Blackbaud\Requests\Constituent;

use Blackbaud\Data\ApiCollection;
use Blackbaud\Data\Constituent\ConstituentSearchResult;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;

/**
 * @phpstan-import-type ConstituentSearchResultDataResponse from ConstituentSearchResult
 *
 * @phpstan-type ApiCollectionResponse array{
 *     count: ?int,
 *     next_link: ?string,
 *     value: array<ConstituentSearchResultDataResponse>
 * }
 */
class SearchConstituent extends Request
{
    use AlwaysThrowOnErrors;

    protected Method $method = Method::GET;

    public function __construct(
        protected string $searchText,
        protected ?string $searchField = null,
        protected ?bool $includeInactive = null,
        protected ?bool $strictSearch = null,
        protected ?string $fundraiserStatus = null,
        protected ?int $limit = null,
        protected ?int $offset = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/constituent/v1/constituents/search';
    }

    protected function defaultQuery(): array
    {
        return [
            'search_text' => $this->searchText,
            'search_field' => $this->searchField,
            'include_inactive' => $this->includeInactive !== null ? var_export($this->includeInactive, true) : null,
            'strict_search' => $this->strictSearch !== null ? var_export($this->strictSearch, true) : null,
            'fundraiser_status' => $this->fundraiserStatus,
            'limit' => $this->limit,
            'offset' => $this->offset,
        ];
    }

    /**
     * @return ApiCollection<ConstituentSearchResult>
     */
    public function createDtoFromResponse(Response $response): ApiCollection
    {
        /** @var ApiCollectionResponse $data */
        $data = $response->json();

        return ApiCollection::from($data['value'], ConstituentSearchResult::class, $data['count'] ?? null, $data['next_link'] ?? null);
    }
}
