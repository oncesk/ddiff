<?php

namespace DDiff\Model;

/**
 * Class DescriptionAwareInterface
 * @package DDiff\Model
 */
interface DescriptionAwareInterface
{
    /**
     * @return string
     */
    public function getDescription() : string;
}
