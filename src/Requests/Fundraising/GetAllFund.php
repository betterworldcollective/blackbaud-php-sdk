<?php

namespace Blackbaud\Requests\Fundraising;

use Blackbaud\Data\ApiCollection;
use Blackbaud\Data\Fundraiser\Fund;
use Carbon\CarbonImmutable;
use JsonException;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;

/**
 * @phpstan-import-type FundDataResponse from Fund
 *
 * @phpstan-type ApiCollectionResponse array{
 *     count: ?int,
 *     next_link: ?string,
 *     value: array<FundDataResponse>
 * }
 */
class GetAllFund extends Request
{
    use AlwaysThrowOnErrors;

    protected Method $method = Method::GET;

    public function __construct(
        protected ?CarbonImmutable $dateAdded,
        protected ?CarbonImmutable $lastModified,
        protected ?string $sortToken,
        protected ?int $limit,
        protected ?int $offset,
        protected bool $includeInactive = false,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/fundraising/v1/funds';
    }

    protected function defaultQuery(): array
    {
        return [
            'date_added' => $this->dateAdded?->toIso8601String(),
            'last_modified' => $this->dateAdded?->toIso8601String(),
            'sort_token' => $this->sortToken,
            'include_inactive' => var_export($this->includeInactive, true),
            'limit' => $this->limit,
            'offset' => $this->offset,
        ];
    }

    /**
     * @return ApiCollection<Fund>
     *
     * @throws JsonException
     */
    public function createDtoFromResponse(Response $response): ApiCollection
    {
        /** @var ApiCollectionResponse $data */
        $data = $response->json();

        return ApiCollection::from($data['value'], Fund::class, $data['count'] ?? null, $data['next_link'] ?? null);
    }
}
