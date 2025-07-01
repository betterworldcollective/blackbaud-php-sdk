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
class GetNode extends Request
{
    use AlwaysThrowOnErrors;

    protected Method $method = Method::GET;

    public function __construct(
        protected int $id,
        protected QueryTypeId $query_type_id,
        protected Product $product,
        protected Module $module,
    ) {}

    public function resolveEndpoint(): string
    {
        return sprintf(
            '/query/querytypes/%s/nodes/%s/availablefields?product=%s&module=%s',
            $this->query_type_id->value,
            $this->id,
            $this->product->value,
            $this->module->value,
        );
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
