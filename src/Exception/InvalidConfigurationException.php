<?php

namespace DDiff\Exception;

/**
 * Class InvalidConfigurationException
 * @package DDiff\Exception
 */
class InvalidConfigurationException extends DDiffException
{
    public function __construct($message = "Invalid configuration", $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
