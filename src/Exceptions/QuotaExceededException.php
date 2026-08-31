<?php

namespace Blackbaud\Exceptions;

use Saloon\Exceptions\Request\Statuses\TooManyRequestsException;

/**
 * Thrown when the SKY API rejects a request because the subscription's quota is exhausted.
 *
 * Blackbaud reports quota exhaustion as a 403 carrying a Retry-After header rather than a 429, so this
 * extends Saloon's rate limit exception to let callers retry both the same way while still being able
 * to tell a quota block (Retry-After is typically the remainder of the day) from a burst limit.
 *
 * @see https://developer.blackbaud.com/skyapi/docs/in-depth-topics/api-request-throttling
 */
final class QuotaExceededException extends TooManyRequestsException {}
