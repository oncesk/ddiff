<?php

namespace DDiff\Result;

/**
 * Interface HeaderOutputAwareInterface
 * @package DDiff\Result
 */
interface HeaderOutputAwareInterface
{
    /**
     * @param $header
     */
    public function writeHeader($header);
}
