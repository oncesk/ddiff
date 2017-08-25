<?php

namespace DDiff\Item\Metadata;

/**
 * Interface MetadataAwareInterface
 * @package DDiff\Item\Metadata
 */
interface MetadataAwareInterface
{
    /**
     * @return MetadataInterface
     */
    public function getMetadata() : MetadataInterface;

    /**
     * @param MetadataInterface $metadata
     * @return $this
     */
    public function setMetadata(MetadataInterface $metadata);
}
