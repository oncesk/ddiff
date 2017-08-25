<?php

namespace DDiff\Exception;

/**
 * Class NotFountException
 */
class NotFountException extends DDiffException
{
    /**
     * NotFountException constructor.
     * @param string $message
     * @param int $code
     * @param \Throwable|null $previous
     */
    public function __construct($message = "Not found", $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
