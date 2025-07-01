<?php

namespace Blackbaud\Resources;

use Blackbaud\Data\Query\FieldNodes;
use Blackbaud\Enums\Module;
use Blackbaud\Enums\Product;
use Blackbaud\Enums\QueryTypeId;
use Blackbaud\Exceptions\InvalidDataException;
use Blackbaud\Requests\Query\GetNode;
use Blackbaud\Requests\Query\GetRootNode;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\BaseResource;

class QueryResource extends BaseResource
{
    /**
     * @throws FatalRequestException
     * @throws RequestException
     * @throws InvalidDataException
     */
    public function getRootNode(QueryTypeId $query_type_id, Product $product, Module $module): FieldNodes
    {
        $dto = $this->connector->send(new GetRootNode($query_type_id, $product, $module))->dto();

        if (! $dto instanceof FieldNodes) {
            throw new InvalidDataException('Invalid data found.');
        }

        return $dto;
    }

    /**
     * @throws FatalRequestException
     * @throws RequestException
     * @throws InvalidDataException
     */
    public function getNode(
        int $id,
        QueryTypeId $query_type_id,
        Product $product,
        Module $module,
    ): FieldNodes {
        $dto = $this->connector->send(new GetNode($id, $query_type_id, $product, $module))->dto();

        if (! $dto instanceof FieldNodes) {
            throw new InvalidDataException('Invalid data found.');
        }

        return $dto;
    }
}
