<?php

namespace Blackbaud\Data\Gift;

use Blackbaud\Data\BaseData;
use Blackbaud\Enums\GiftAcknowledgementStatus;
use Carbon\CarbonImmutable;

/**
 * @phpstan-type AcknowledgementDataResponse array{
 *     date?: string|null,
 *     letter?: string|null,
 *     status: string
 * }
 */
class Acknowledgement extends BaseData
{
    public function __construct(
        public GiftAcknowledgementStatus $status,
        public ?CarbonImmutable $date = null,
        public ?string $letter = null,
    ) {}

    /**
     * @param  AcknowledgementDataResponse  $data
     */
    public static function from(array $data): Acknowledgement
    {
        /** @var ?string $date */
        $date = data_get($data, 'date');

        return new self(
            status: GiftAcknowledgementStatus::from($data['status']),
            date: $date
                ? CarbonImmutable::parse($date)
                : null,
            letter: $data['letter'] ?? null,
        );
    }
}
