<?php

namespace Blackbaud\Resources;

use Blackbaud\Exceptions\BadRequestException;
use Blackbaud\Exceptions\UnauthorizedException;
use Blackbaud\Requests\Constituent\UpdateConstituentPhone;
use Saloon\Http\BaseResource;

class ConstituentPhoneResource extends BaseResource
{
    /**
     * @param  array<string, mixed>  $properties
     * @return true if the update is successful, otherwise it will throw an exception
     *
     * @throws BadRequestException
     * @throws UnauthorizedException
     *
     * @see https://developer.sky.blackbaud.com/api#api=56b76470069a0509c8f1c5b3&operation=EditConstituentPhone List of available properties
     */
    public function update(int $id, array $properties): true
    {
        $this->connector->send(new UpdateConstituentPhone($id, $properties));

        return true;
    }
}
