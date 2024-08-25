<?php

namespace App\Exceptions;

use RuntimeException;

/**
 * Signifies that an occurrence was attempted to be created,
 * whereas another occurrence already exists, and they overlap.
 */
class EventOverlappingException extends \Exception
{
    protected $message = "An existing event or occurence is overlapping with this event";
    protected $code = 403;
}