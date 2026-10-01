<?php

namespace Blackbaud\Resources;

use Blackbaud\Data\ApiCollection;
use Blackbaud\Data\Fundraiser\Package;
use Blackbaud\Exceptions\BadRequestException;
use Blackbaud\Exceptions\InvalidDataException;
use Blackbaud\Exceptions\ObjectNotFoundException;
use Blackbaud\Exceptions\QuotaExceededException;
use Blackbaud\Exceptions\UnauthorizedException;
use Blackbaud\Requests\Fundraising\GetAllPackage;
use Blackbaud\Requests\Fundraising\GetPackage;
use Carbon\CarbonImmutable;
use Saloon\Exceptions\Request\Statuses\TooManyRequestsException;
use Saloon\Http\BaseResource;

class PackageResource extends BaseResource
{
    /**
     * @return ApiCollection<Package>
     *
     * @throws BadRequestException
     * @throws UnauthorizedException
     * @throws InvalidDataException
     * @throws TooManyRequestsException
     * @throws QuotaExceededException
     *
     * @see https://developer.sky.blackbaud.com/api#api=58bdd6c8d7dcde06046081d7&operation=ListPackages
     */
    public function all(
        ?CarbonImmutable $dateAdded = null,
        ?CarbonImmutable $lastModified = null,
        ?string $sortToken = null,
        ?int $limit = null,
        ?int $offset = null,
        bool $includeInactive = false,
        ?int $appealId = null,
    ): ApiCollection {
        $packages = $this->connector->send(
            new GetAllPackage(
                $dateAdded,
                $lastModified,
                $sortToken,
                $limit,
                $offset,
                $includeInactive,
                $appealId
            )
        )->dto();

        if (! $packages instanceof ApiCollection) {
            throw new InvalidDataException('Invalid data found.');
        }

        return $packages;
    }

    /**
     * @throws ObjectNotFoundException
     * @throws UnauthorizedException
     * @throws InvalidDataException
     * @throws TooManyRequestsException
     * @throws QuotaExceededException
     *
     * @see https://developer.sky.blackbaud.com/api#api=58bdd6c8d7dcde06046081d7&operation=GetPackage
     */
    public function get(int $id): Package
    {
        $package = $this->connector->send(new GetPackage($id))->dto();

        if (! $package instanceof Package) {
            throw new InvalidDataException('Invalid data found.');
        }

        return $package;
    }
}
