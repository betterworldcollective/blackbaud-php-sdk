<?php

namespace BlackbaudSdk\Data;

class Currency
{
    public function __construct(
        public float $value,
    ) {}

    public static function make(float $value): Currency
    {
        return new self($value);
    }
}
