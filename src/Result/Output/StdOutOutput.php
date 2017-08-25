<?php

namespace DDiff\Result\Output;

use DDiff\Destination\Item\StateInterface;
use DDiff\Item\Context\ContextAwareInterface;
use DDiff\Item\Context\ContextAwareTrait;
use DDiff\Item\Context\ContextInterface;
use DDiff\Result\FormatterInterface;
use DDiff\Result\HeaderOutputAwareInterface;
use DDiff\Result\OutputInterface;
use DDiff\Stub\NullObjectInterface;

/**
 * Class StdOutOutput
 * @package DDiff\Result\Output
 */
class StdOutOutput implements OutputInterface, ContextAwareInterface, HeaderOutputAwareInterface
{
    use ContextAwareTrait;

    /**
     * StdOutOutput constructor.
     * @param ContextInterface|null $context
     */
    public function __construct(ContextInterface $context = null)
    {
        if ($context) {
            $this->setContext($context);
        }
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'stdout';
    }

    /**
     * @param string $header
     */
    public function writeHeader($header)
    {
        if ($header) {
            if (is_string($header)) {
                fputs(STDOUT, $header . PHP_EOL);
            }
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

        if (!$context instanceof NullObjectInterface) {
            $data = $formatter->format($state, $context);

            if ($data) {
                if (is_string($data)) {
                    fputs(STDOUT, $data . PHP_EOL);
                }
            }
        }
    }
}
