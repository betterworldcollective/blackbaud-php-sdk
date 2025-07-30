<?php

namespace Blackbaud\Exceptions;

use Exception;

final class ObjectNotFoundException extends Exception
{
    /** @phpstan-ignore missingType.property */
    protected $message = 'The requested object was not found.';

    /** @phpstan-ignore missingType.property */
    protected $code = 404;
}
