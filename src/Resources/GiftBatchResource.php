<?php

namespace Blackbaud\Resources;

use Blackbaud\Exceptions\BadRequestException;
use Blackbaud\Exceptions\UnauthorizedException;
use Blackbaud\Requests\GiftBatch\CreateGiftBatch;
use Blackbaud\Requests\GiftBatch\CreateGiftBatchGifts;
use Saloon\Http\BaseResource;

class GiftBatchResource extends BaseResource
{
    /**
     * @param  array<string, mixed>  $properties
     * @return string The batch ID of the newly created gift batch returned by the API response
     *
     * @throws BadRequestException
     * @throws UnauthorizedException
     *
     * @see https://developer.sky.blackbaud.com/api#api=gift-batch&operation=CreateBatch List of available properties
     */
    public function create(array $properties): string
    {
        /** @var array{batch_id: string} $response */
        $response = $this->connector->send(new CreateGiftBatch($properties))->array();

        return $response['batch_id'];
    }

    /**
     * @param  string  $batchId  The immutable system record ID of the batch
     * @param  array<string, mixed>  $properties  A collection of gifts to add to the batch
     * @return array{gifts?: array<int, array<string, mixed>>, errors?: array<int, array<string, mixed>>}
     *
     * @throws BadRequestException
     * @throws UnauthorizedException
     *
     * @see https://developer.sky.blackbaud.com/api#api=58bdd5edd7dcde06046081d6&operation=AddGiftsToBatch List of available properties
     */
    public function createGifts(string $batchId, array $properties): array
    {
        /** @var array{gifts?: array<int, array<string, mixed>>, errors?: array<int, array<string, mixed>>} $response */
        $response = $this->connector->send(new CreateGiftBatchGifts($batchId, $properties))->array();

        return $response;
    }
}
