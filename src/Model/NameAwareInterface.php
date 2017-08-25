<?php

namespace DDiff\Model;

/**
 * Class NameAwareInterface
 * @package DDiff\Model
 */
interface NameAwareInterface
{
    /**
     * @return string
     */
    public function getName() : string;
}
