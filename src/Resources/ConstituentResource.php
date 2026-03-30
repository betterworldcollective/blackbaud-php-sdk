<?php

namespace Blackbaud\Resources;

use Blackbaud\Data\ApiCollection;
use Blackbaud\Data\Constituent\Constituent;
use Blackbaud\Data\Constituent\ConstituentSearchResult;
use Blackbaud\Exceptions\BadRequestException;
use Blackbaud\Exceptions\InvalidDataException;
use Blackbaud\Exceptions\ObjectNotFoundException;
use Blackbaud\Exceptions\UnauthorizedException;
use Blackbaud\Requests\Constituent\CreateConstituent;
use Blackbaud\Requests\Constituent\GetConstituent;
use Blackbaud\Requests\Constituent\SearchConstituent;
use Blackbaud\Requests\Constituent\UpdateConstituent;
use Saloon\Http\BaseResource;

class ConstituentResource extends BaseResource
{
    /**
     * @throws ObjectNotFoundException
     * @throws UnauthorizedException
     * @throws InvalidDataException
     */
    public function get(int $id): Constituent
    {
        $constituent = $this->connector->send(new GetConstituent($id))->dto();

        if (! $constituent instanceof Constituent) {
            throw new InvalidDataException('Invalid data found.');
        }

        return $constituent;
    }

    /**
     * @return ApiCollection<ConstituentSearchResult>
     *
     * @throws BadRequestException
     * @throws UnauthorizedException
     * @throws InvalidDataException
     *
     * @see https://developer.sky.blackbaud.com/api#api=56b76470069a0509c8f1c5b3&operation=SearchConstituent
     */
    public function search(
        string $searchText,
        ?string $searchField = null,
        ?bool $includeInactive = null,
        ?bool $strictSearch = null,
        ?string $fundraiserStatus = null,
        ?int $limit = null,
        ?int $offset = null,
    ): ApiCollection {
        $results = $this->connector->send(
            new SearchConstituent(
                $searchText,
                $searchField,
                $includeInactive,
                $strictSearch,
                $fundraiserStatus,
                $limit,
                $offset,
            )
        )->dto();

        if (! $results instanceof ApiCollection) {
            throw new InvalidDataException('Invalid data found.');
        }

        return $results;
    }

    /**
     * @param  array<string, mixed>  $properties
     * @return int The ID of the newly created constituent returned by the API response
     *
     * @throws BadRequestException
     * @throws UnauthorizedException
     *
     * @see https://developer.sky.blackbaud.com/api#api=56b76470069a0509c8f1c5b3&operation=CreateConstituent List of available properties
     */
    public function create(array $properties): int
    {
        /** @var array{id: string} $response */
        $response = $this->connector->send(new CreateConstituent($properties))->array();

        return (int) $response['id'];
    }

    /**
     * @param  array<string, mixed>  $properties
     * @return true if the update is successful, otherwise it will throw an exception
     *
     * @throws BadRequestException
     * @throws UnauthorizedException
     *
     * @see https://developer.sky.blackbaud.com/api#api=56b76470069a0509c8f1c5b3&operation=EditConstituent List of available properties
     */
    public function update(int $id, array $properties): true
    {
        $this->connector->send(new UpdateConstituent($id, $properties));

        return true;
    }
}
