<?php

namespace Blackbaud\Resources;

use Blackbaud\Data\ApiCollection;
use Blackbaud\Data\Fundraiser\Fund;
use Blackbaud\Exceptions\BadRequestException;
use Blackbaud\Exceptions\InvalidDataException;
use Blackbaud\Exceptions\ObjectNotFoundException;
use Blackbaud\Exceptions\UnauthorizedException;
use Blackbaud\Requests\Fundraising\GetAllFund;
use Blackbaud\Requests\Fundraising\GetFund;
use Carbon\CarbonImmutable;
use Saloon\Http\BaseResource;

class FundResource extends BaseResource
{
    /**
     * @return ApiCollection<Fund>
     *
     * @throws BadRequestException
     * @throws UnauthorizedException
     * @throws InvalidDataException
     */
    public function all(
        ?CarbonImmutable $dateAdded = null,
        ?CarbonImmutable $lastModified = null,
        ?string $sortToken = null,
        ?int $limit = null,
        ?int $offset = null,
        bool $includeInactive = false,
    ): ApiCollection {
        $funds = $this->connector->send(
            new GetAllFund(
                $dateAdded,
                $lastModified,
                $sortToken,
                $limit,
                $offset,
                $includeInactive
            )
        )->dto();

        if (! $funds instanceof ApiCollection) {
            throw new InvalidDataException('Invalid data found.');
        }

        return $funds;
    }

    /**
     * @throws ObjectNotFoundException
     * @throws UnauthorizedException
     * @throws InvalidDataException
     */
    public function get(int $id): Fund
    {
        $fund = $this->connector->send(new GetFund($id))->dto();

        if (! $fund instanceof Fund) {
            throw new InvalidDataException('Invalid data found.');
        }

        return $fund;
    }
}
