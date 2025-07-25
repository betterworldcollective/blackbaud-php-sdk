<?php

namespace Blackbaud\Resources;

use Blackbaud\Data\ApiCollection;
use Blackbaud\Data\Fundraiser\Fund;
use Blackbaud\Exceptions\InvalidDataException;
use Blackbaud\Requests\Fundraising\GetAllFund;
use Blackbaud\Requests\Fundraising\GetFund;
use Carbon\CarbonImmutable;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\BaseResource;

class FundResource extends BaseResource
{
    /**
     * @return ApiCollection<Fund>
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
     * @throws FatalRequestException
     * @throws RequestException
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
