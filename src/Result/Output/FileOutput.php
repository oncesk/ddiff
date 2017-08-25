<?php

namespace DDiff\Result\Output;

use DDiff\Destination\Item\StateInterface;
use DDiff\Exception\DDiffException;
use DDiff\Exception\InvalidConfigurationException;
use DDiff\Item\Context\ContextAwareInterface;
use DDiff\Item\Context\ContextAwareTrait;
use DDiff\Item\Context\ContextInterface;
use DDiff\Model\ConfigurableInterface;
use DDiff\Result\FormatterInterface;
use DDiff\Result\HeaderOutputAwareInterface;
use DDiff\Result\OutputInterface;

/**
 * Class FileOutput
 * @package DDiff\Result\Output
 */
class FileOutput implements OutputInterface, ContextAwareInterface, HeaderOutputAwareInterface, ConfigurableInterface
{
    use ContextAwareTrait;

    /**
     * @var string
     */
    protected $file;

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'file';
    }

    /**
     * @param ContextInterface $context
     * @throws DDiffException
     * @throws InvalidConfigurationException
     */
    public function configure(ContextInterface $context)
    {
        if (is_resource($this->file)) {
            return;
        }

        if (!$context->has('file')) {
            throw new InvalidConfigurationException('Could not use FileOutput becase file not passed, use -c file=test.sql');
        }

        $this->file = fopen($context->get('file'), 'w+');

        if (!$this->file) {
            throw new DDiffException('Could not create resource for file');
        }
    }

    /**
     * @param $header
     */
    public function writeHeader($header)
    {
        if ($header) {
            $this->doWrite($header);
        }
    }

    /**
     * @param StateInterface $state
     * @param FormatterInterface $formatter
     */
    public function write(StateInterface $state, FormatterInterface $formatter)
    {
        $context = $this->getContext();

        if ($state instanceof ContextAwareInterface) {
            $context = $state->getContext();
        }

        $data = $formatter->format($state, $context);

        if ($data) {
            $this->doWrite($data);
        }
    }

    /**
     *
     */
    public function __destruct()
    {
        if (is_resource($this->file)) {
            fclose($this->file);
        }
    }

    /**
     * @param $data
     * @throws DDiffException
     */
    protected function doWrite($data)
    {
        if (!is_resource($this->file)) {
            throw new DDiffException('Could not write, resource is closed or not opened');
        }

        fputs($this->file, $data . PHP_EOL);
    }
}
