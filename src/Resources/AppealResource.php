<?php

namespace Blackbaud\Resources;

use Blackbaud\Data\ApiCollection;
use Blackbaud\Data\Fundraiser\Appeal;
use Blackbaud\Exceptions\BadRequestException;
use Blackbaud\Exceptions\InvalidDataException;
use Blackbaud\Exceptions\ObjectNotFoundException;
use Blackbaud\Exceptions\QuotaExceededException;
use Blackbaud\Exceptions\UnauthorizedException;
use Blackbaud\Requests\Fundraising\GetAllAppeal;
use Blackbaud\Requests\Fundraising\GetAppeal;
use Carbon\CarbonImmutable;
use Saloon\Exceptions\Request\Statuses\TooManyRequestsException;
use Saloon\Http\BaseResource;

class AppealResource extends BaseResource
{
    /**
     * @return ApiCollection<Appeal>
     *
     * @throws BadRequestException
     * @throws UnauthorizedException
     * @throws InvalidDataException
     * @throws TooManyRequestsException
     * @throws QuotaExceededException
     *
     * @see https://developer.sky.blackbaud.com/api#api=58bdd6c8d7dcde06046081d7&operation=ListAppeals
     */
    public function all(
        ?CarbonImmutable $dateAdded = null,
        ?CarbonImmutable $lastModified = null,
        ?string $sortToken = null,
        ?int $limit = null,
        ?int $offset = null,
        bool $includeInactive = false,
    ): ApiCollection {
        $appeals = $this->connector->send(
            new GetAllAppeal(
                $dateAdded,
                $lastModified,
                $sortToken,
                $limit,
                $offset,
                $includeInactive
            )
        )->dto();

        if (! $appeals instanceof ApiCollection) {
            throw new InvalidDataException('Invalid data found.');
        }

        return $appeals;
    }

    /**
     * @throws ObjectNotFoundException
     * @throws UnauthorizedException
     * @throws InvalidDataException
     * @throws TooManyRequestsException
     * @throws QuotaExceededException
     *
     * @see https://developer.sky.blackbaud.com/api#api=58bdd6c8d7dcde06046081d7&operation=GetAppeal
     */
    public function get(int $id): Appeal
    {
        $appeal = $this->connector->send(new GetAppeal($id))->dto();

        if (! $appeal instanceof Appeal) {
            throw new InvalidDataException('Invalid data found.');
        }

        return $appeal;
    }
}
