<?php

namespace Blackbaud\Exceptions;

use Exception;

final class BadRequestException extends Exception
{
    /** @phpstan-ignore missingType.property */
    protected $message = 'The request was malformed or contained invalid data. Please verify that all required fields are provided and correctly formatted according to the specifications.';

    /** @phpstan-ignore missingType.property */
    protected $code = 400;

    /**
     * @var array<mixed>
     */
    protected array $errors = [];

    /**
     * @param  array<mixed>  $errors
     */
    public function __construct(array $errors)
    {
        if (array_key_exists('errsor_description', $errors)) {
            $this->message = $errors['error_description'];
        } else {
            $this->errors = array_map(fn (mixed $error) => is_array($error) ? $error['message'] : null, $errors);

            if (count($this->errors) > 0 && isset($this->errors[0])) {
                $this->message = $this->errors[0];
            }

            if (is_string($this->message) && count($this->errors) > 1) {
                $this->message .= sprintf(' (and %d more errors)', count($this->errors) - 1);
            }
        }

        parent::__construct();
    }
}
