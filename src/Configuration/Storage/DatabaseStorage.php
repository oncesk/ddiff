<?php

namespace DDiff\Configuration\Storage;

/**
 * Class DatabaseStorage
 * @package DDiff\Configuration\Storage
 */
class DatabaseStorage extends Storage
{
    /**
     * @param string $name
     * @return string
     */
    protected function formatName(string $name)
    {
        return sprintf(
            'db.%s.json',
            $name
        );
    }
}
