<?php

namespace Blackbaud\Resources;

use Blackbaud\Exceptions\BadRequestException;
use Blackbaud\Exceptions\UnauthorizedException;
use Blackbaud\Requests\Constituent\CreateConstituentAddress;
use Saloon\Http\BaseResource;

class ConstituentAddressResource extends BaseResource
{
    /**
     * @param  array<string, mixed>  $properties
     * @return int The ID of the newly created constituent address returned by the API response
     *
     * @throws BadRequestException
     * @throws UnauthorizedException
     *
     * @see https://developer.sky.blackbaud.com/api#api=56b76470069a0509c8f1c5b3&operation=CreateConstituentAddress List of available properties
     */
    public function create(array $properties): int
    {
        /** @var array{id: string} $response */
        $response = $this->connector->send(new CreateConstituentAddress($properties))->array();

        return (int) $response['id'];
    }
}
