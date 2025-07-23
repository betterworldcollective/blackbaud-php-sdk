<?php

namespace Blackbaud\Resources;

use Blackbaud\Data\ApiCollection;
use Blackbaud\Data\CustomField\CustomField;
use Blackbaud\Exceptions\InvalidDataException;
use Blackbaud\Requests\Constituent\CreateConstituentCustomField;
use Blackbaud\Requests\Constituent\GetAllConstituentCustomField;
use Blackbaud\Requests\Constituent\GetConstituentCustomField;
use Blackbaud\Requests\Constituent\UpdateConstituentCustomField;
use Carbon\CarbonImmutable;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\BaseResource;

class ConstituentCustomFieldResource extends BaseResource
{
    /**
     * @return ApiCollection<CustomField>
     *
     * @throws RequestException
     * @throws InvalidDataException
     * @throws FatalRequestException
     */
    public function all(
        ?CarbonImmutable $dateAdded = null,
        ?CarbonImmutable $lastModified = null,
        ?string $sortToken = null,
        ?int $limit = null,
        ?int $offset = null,
        bool $includeCount = true,
    ): ApiCollection {
        $customFields = $this->connector->send(
            new GetAllConstituentCustomField(
                $dateAdded,
                $lastModified,
                $sortToken,
                $limit,
                $offset,
                $includeCount
            )
        )->dto();

        if (! $customFields instanceof ApiCollection) {
            throw new InvalidDataException('Invalid data found.');
        }

        return $customFields;
    }

    /**
     * @return ApiCollection<CustomField>
     *
     * @throws FatalRequestException
     * @throws RequestException
     * @throws InvalidDataException
     */
    public function get(int $id): ApiCollection
    {
        $customFields = $this->connector->send(new GetConstituentCustomField($id))->dto();

        if (! $customFields instanceof ApiCollection) {
            throw new InvalidDataException('Invalid data found.');
        }

        return $customFields;
    }

    /**
     * @param  array<string, mixed>  $properties
     * @return int The ID of the newly created constituent custom form returned by the API response
     *
     * @throws FatalRequestException
     * @throws RequestException
     *
     * @see https://developer.sky.blackbaud.com/api#api=56b76470069a0509c8f1c5b3&operation=CreateConstituentCustomField List of available properties
     */
    public function create(array $properties): int
    {
        /** @var array{id: string} $response */
        $response = $this->connector->send(new CreateConstituentCustomField($properties))->array();

        return (int) $response['id'];
    }

    /**
     * @param  array<string, mixed>  $properties
     * @return true if the update is successful, otherwise it will throw an exception
     *
     * @throws FatalRequestException
     * @throws RequestException
     *
     * @see https://developer.sky.blackbaud.com/api#api=56b76470069a0509c8f1c5b3&operation=EditConstituentCustomField List of available properties
     */
    public function update(int $id, array $properties): true
    {
        $this->connector->send(new UpdateConstituentCustomField($id, $properties));

        return true;
    }
}
