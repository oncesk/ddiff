<?php

namespace DDiff\Item\Metadata;
use DDiff\Item\FieldInterface;
use DDiff\Item\ItemInterface;
use DDiff\Item\ValueAwareInterface;

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

            if ($this instanceof FieldInterface && $this instanceof ValueAwareInterface) {
                $type = gettype($this->getValue());
                $this->metadata = new Metadata($type, $type);
            } else {
                $this->metadata = new NullMetadata();
            }
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
