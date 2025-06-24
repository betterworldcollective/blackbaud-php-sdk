<?php

namespace BlackbaudSdk\Data;

use Carbon\CarbonImmutable;

class FuzzyDate
{
    public function __construct(
        public int $d,
        public int $m,
        public int $y,
    ) {}

    public static function from(?CarbonImmutable $date): ?self
    {
        return $date ? new FuzzyDate($date->day, $date->month, $date->year) : null;
    }

    /**
     * @param  array{y: int, m: int, d: int}|null  $date
     */
    public static function toCarbon(?array $date): ?CarbonImmutable
    {
        return is_array($date)
            ? CarbonImmutable::createFromDate(
                $date['y'],
                $date['m'],
                $date['d']
            )
            : null;
    }
}
