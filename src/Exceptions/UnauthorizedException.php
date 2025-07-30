<?php

namespace Blackbaud\Exceptions;

use Exception;

final class UnauthorizedException extends Exception
{
    /** @phpstan-ignore missingType.property */
    protected $code = 401;

    public function __construct(mixed $message)
    {
        if (is_string($message)) {
            $this->message = $message;
        }

        parent::__construct();
    }
}
