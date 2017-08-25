<?php

namespace DDiff\Item\Metadata;

/**
 * Class MetadataAwareTrait
 * @package DDiff\Item\Metadata
 */
trait MetadataAwareTrait
{
    /**
     * @var MetadataInterface
     */
    protected $metadata;

    /**
     * @return MetadataInterface
     */
    public function getMetadata() : MetadataInterface
    {
        if (null === $this->metadata) {
            $this->metadata = new NullMetadata();
        }

        return $this->metadata;
    }

    /**
     * @param MetadataInterface $metadata
     * @return $this
     */
    public function setMetadata(MetadataInterface $metadata)
    {
        $this->metadata = $metadata;

        return $this;
    }
}
