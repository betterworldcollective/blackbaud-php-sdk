<?php

namespace Blackbaud\Requests\Query;

use Blackbaud\Data\Query\FieldNodes;
use Blackbaud\Enums\Module;
use Blackbaud\Enums\Product;
use Blackbaud\Enums\QueryTypeId;
use JsonException;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;

/**
 * @phpstan-import-type FieldNodesResponse from FieldNodes
 */
class GetRootNode extends Request
{
    use AlwaysThrowOnErrors;

    protected Method $method = Method::GET;

    public function __construct(
        protected QueryTypeId $query_type_id,
        protected Product $product,
        protected Module $module,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/query/querytypes/{$this->query_type_id->value}/availablefields?product={$this->product->value}&module={$this->module->value}";
    }

    /**
     * @throws JsonException
     */
    public function createDtoFromResponse(Response $response): FieldNodes
    {
        /** @var FieldNodesResponse $data */
        $data = $response->json();

        return FieldNodes::from($data);
    }
}
