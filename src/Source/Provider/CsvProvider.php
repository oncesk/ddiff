<?php

namespace DDiff\Source\Provider;

use DDiff\Csv\Reader;
use DDiff\Csv\ReaderInterface;
use DDiff\Destination\Item\Finder\CsvFinder;
use DDiff\Destination\Item\FinderFactoryInterface;
use DDiff\Destination\Item\FinderInterface;
use DDiff\Exception\DDiffException;
use DDiff\Item\Context\Context;
use DDiff\Item\Context\ContextInterface;
use DDiff\Item\Item;
use DDiff\Item\ItemInterface;
use DDiff\Item\NullableItem;
use DDiff\Item\ValueField;
use DDiff\Model\ConfigurableInterface;

/**
 * Class CsvProvider
 * @package DDiff\Source\Provider
 */
class CsvProvider implements ProviderInterface, ConfigurableInterface, FinderFactoryInterface
{
    /**
     * @var resource
     */
    protected $resource;

    /**
     * @var string
     */
    protected $delimiter = ',';

    /**
     * @var int
     */
    protected $length;

    /**
     * @var ReaderInterface
     */
    protected $reader;

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'csv';
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        // TODO: Implement init() method.
    }

    /**
     * @param ContextInterface $context
     * @return FinderInterface
     */
    public function createDestinationFinder(ContextInterface $context): FinderInterface
    {
        $finder = new CsvFinder();
        $context->set('csv.dst.file', $context->get('csv.file'));

        return $finder;
    }

    /**
     * @param ContextInterface $context
     * @throws DDiffException
     */
    public function configure(ContextInterface $context)
    {
        if (!$context->has('csv.file')) {
            throw new DDiffException('Pass csv.file context variable');
        }

        $file = $context->get('csv.file');
        $this->reader = new Reader($file);
    }

    /**
     * @return bool
     */
    public function eof()
    {
        return $this->reader->eof();
    }

    /**
     * @inheritdoc
     */
    public function next()
    {
        //  do nothing because of readLine method will move pointer
    }

    /**
     * @return ItemInterface
     */
    public function getSourceItem(): ItemInterface
    {
        try {
            $values = $this->reader->read();
        } catch (DDiffException $exception) {
            return new NullableItem();
        }

        $item = new Item();
        $attributes = array_combine($this->reader->getFieldNames(), $values);
        foreach ($attributes as $key => $value) {
            $item->addField(new ValueField($key, $value));
        }

        return $item;
    }
}
