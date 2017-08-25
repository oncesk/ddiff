<?php

namespace DDiff\Source\Provider;

use DDiff\Item\ItemInterface;
use DDiff\Model\NameAwareInterface;

/**
 * Interface ProviderInterface
 * @package DDiff\Source\Provider
 */
interface ProviderInterface extends NameAwareInterface
{
    /**
     * @return void
     */
    public function init();

    /**
     * If no more records
     *
     * @return bool
     */
    public function eof();

    /**
     * Move pointer to the next item
     *
     * @return void
     */
    public function next();

    /**
     * @return ItemInterface
     */
    public function getSourceItem() : ItemInterface;
}
