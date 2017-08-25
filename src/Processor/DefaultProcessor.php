<?php

namespace DDiff\Processor;

use DDiff\Configuration\ConfigurationInterface;
use DDiff\Destination\Item\FinderFactoryInterface;
use DDiff\Destination\Item\FinderInterface;
use DDiff\Destination\Item\RemovedStateDeterminer;
use DDiff\Destination\Item\StateDeterminerInterface;
use DDiff\Exception\DDiffException;
use DDiff\Item\Context\Context;
use DDiff\Item\Context\ContextAwareInterface;
use DDiff\Item\Context\ContextInterface;
use DDiff\Model\CleanAwareInterface;
use DDiff\Model\ConfigurableInterface;
use DDiff\Result\FormatterHeaderAwareInterface;
use DDiff\Result\FormatterInterface;
use DDiff\Result\HeaderOutputAwareInterface;
use DDiff\Result\OutputInterface;
use DDiff\Source\Provider\ProviderFactoryInterface;
use DDiff\Source\Provider\ProviderInterface;
use DDiff\Stub\NullObjectInterface;

/**
 * Class DefaultProcessor
 * @package DDiff\Processor
 */
class DefaultProcessor implements ProcessorInterface
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'default';
    }

    /**
     * @param ConfigurationInterface $configuration
     */
    public function process(ConfigurationInterface $configuration)
    {
        $context = $configuration->getContext();
        $sourceProvider = $configuration->getSourceProvider();

        if ($sourceProvider instanceof NullObjectInterface) {
            throw new \LogicException('Could not process configuration because of SourceProvider is NullObject');
        }

        if ($sourceProvider instanceof ContextAwareInterface) {
            $sourceProvider->setContext($context);
        }

        $finder = $configuration->getFinder();

        if ($finder instanceof NullObjectInterface) {
            throw new \LogicException('Could not process configuration because of Finder is NullObject');
        }

        if ($finder instanceof ContextAwareInterface) {
            $finder->setContext($context);
        }

        $stateDeterminer = $configuration->getStateDeterminer();
        $output = $configuration->getOutput();
        $formatter = $configuration->getFormatter();

        //  trying to detect items which were removed in source
        if ($sourceProvider instanceof FinderFactoryInterface && $finder instanceof ProviderFactoryInterface) {
            //  it looks like we can track deleted
            try {
                $ctx = clone $context;
                $sourceFinder = $sourceProvider->createDestinationFinder($ctx);
                $destinationProvider = $finder->createSourceProvider($ctx);

//                $parameters = $context->getAll();
//                if ($sourceFinder instanceof ContextAwareInterface) {
//                    $parameters = array_merge($parameters, $sourceFinder->getContext()->getAll());
//                }
//
//                if ($destinationProvider instanceof ContextAwareInterface) {
//                    $parameters = array_merge($parameters, $destinationProvider->getContext()->getAll());
//                }
//                $ctx = new Context($parameters);

                $this->doProcess(
                    $destinationProvider,
                    $sourceFinder,
                    $formatter,
                    $output,
                    new RemovedStateDeterminer($stateDeterminer),
                    $configuration,
                    $ctx
                );

            } catch (DDiffException $exception) {
                //  do nothing now
                //  todo add logging
                echo $exception->getMessage();die;
            }
        }

        $this->doProcess(
            $sourceProvider,
            $finder,
            $formatter,
            $output,
            $stateDeterminer,
            $configuration,
            $context
        );
    }

    /**
     * @param ProviderInterface $sourceProvider
     * @param FinderInterface $finder
     * @param FormatterInterface $formatter
     * @param OutputInterface $output
     * @param StateDeterminerInterface $determiner
     * @param ConfigurationInterface $configuration
     * @param ContextInterface $context
     */
    protected function doProcess(
        ProviderInterface $sourceProvider,
        FinderInterface $finder,
        FormatterInterface $formatter,
        OutputInterface $output,
        StateDeterminerInterface $determiner,
        ConfigurationInterface $configuration,
        ContextInterface $context
    )
    {
        if ($output instanceof ContextAwareInterface) {
            $output->setContext($context);
        }

        if ($output instanceof ConfigurableInterface) {
            $output->configure($context);
        }

        if ($formatter instanceof ContextAwareInterface) {
            $formatter->setContext($context);
        }

        if ($formatter instanceof ConfigurableInterface) {
            $formatter->configure($context);
        }

        if ($sourceProvider instanceof ConfigurableInterface) {
            $sourceProvider->configure($context);
        }

        if ($finder instanceof ConfigurableInterface) {
            $finder->configure($context);
        }

        $sourceProvider->init();
        $finder->init();

        if ($formatter instanceof FormatterHeaderAwareInterface && $output instanceof HeaderOutputAwareInterface) {
            $header = $formatter->formatHeader($configuration);
            $output->writeHeader($header);
        }

        //  trying to detect new and update data
        while (!$sourceProvider->eof()) {
            $sourceItem = $sourceProvider->getSourceItem();

            if (!$sourceItem instanceof NullObjectInterface) {
                $state = $determiner->determine($sourceItem, $finder);
                $output->write($state, $formatter);
            }

            $sourceProvider->next();
        }

        if ($sourceProvider instanceof CleanAwareInterface) {
            $sourceProvider->clean();
        }

        if ($finder instanceof CleanAwareInterface) {
            $finder->clean();
        }
    }
}
