<?php

namespace DDiff\Command;

use DDiff\Configuration\Configuration;
use DDiff\Exception\InvalidConfigurationException;
use DDiff\Item\Context\Context;
use DDiff\Processor\ProcessorInterface;
use DDiff\Source\Provider\PoolInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use DDiff\Result\Formatter\ProviderInterface as FormatterProviderInterface;
use DDiff\Result\Output\ProviderInterface as OutputProviderInterface;

/**
 * Class DiffCommand
 * @package DDiff\Command
 */
class DiffCommand extends Command implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this
            ->setName('ddiff:do:diff')
            ->setDescription('Perform diff calculation')
            ->addArgument('file', InputArgument::OPTIONAL, 'Write to the file')
            ->addOption('output', 'o', InputOption::VALUE_OPTIONAL, 'Output file or name of OutputHandlers, [file | stdout]', 'stdout')
            ->addOption('processor', 'P', InputOption::VALUE_OPTIONAL, 'Operational Processor, should be service name or processor name', 'processor.default')
            ->addOption('formatter', 'f', InputOption::VALUE_OPTIONAL, 'Output formatter', 'sql')
            ->addOption('provider', 'p', InputOption::VALUE_OPTIONAL, 'Source provider [csv|db.pdo]', 'db.pdo')
            ->addOption('finder', 'F', InputOption::VALUE_OPTIONAL, 'Destination item finder', 'db.pdo.table.finder')
            ->addOption('context', 'c', InputOption::VALUE_IS_ARRAY | InputOption::VALUE_OPTIONAL, 'Set context property, -c db.config=test', [])
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $formatterProvider = $this->getFormatterProvider();
        $outputProvider = $this->getOutputProvider();
        $sourcePool = $this->getSourcePool();

        $formatter = $formatterProvider->getFormatter($input->getOption('formatter'));

        $contextOptions = [];
        $output = $input->getOption('output');
        if ($input->getArgument('file')) {
            $output = 'file';
            $contextOptions['file'] = $input->getArgument('file');
        }

        $output = $outputProvider->getOutput($output);
        $processor = $this->getProcessor($input->getOption('processor'));
        $stateDeterminer = $this->container->get('state.determiner.default');
        $sourceProvider = $sourcePool->getProvider($input->getOption('provider'));
        $finder = $this->container->get('destination.finder.pdo');  // todo refactor this

        $contextOptions = array_merge(
            $this->prepareContextOptions($input->getOption('context')),
            $contextOptions
        );
        $context = new Context($contextOptions);

        $configuration = new Configuration();
        $configuration
            ->setContext($context)
            ->setFinder($finder)
            ->setStateDeterminer($stateDeterminer)
            ->setSourceProvider($sourceProvider)
            ->setOutput($output)
            ->setFormatter($formatter)
        ;

        $processor->process($configuration);
    }

    /**
     * @return OutputProviderInterface
     */
    protected function getOutputProvider()
    {
        return $this->container->get('result.output.provider');
    }

    /**
     * @return FormatterProviderInterface
     */
    protected function getFormatterProvider()
    {
        return $this->container->get('result.formatter.provider');
    }

    /**
     * @return PoolInterface
     */
    protected function getSourcePool()
    {
        return $this->container->get('source.provider.pool');
    }

    /**
     * @param string $name
     * @return ProcessorInterface
     */
    protected function getProcessor(string $name)
    {
        if ($this->container->has($name)) {
            $service = $this->container->get($name);

            if (!$service instanceof ProcessorInterface) {
                throw new InvalidConfigurationException('Processor should be instance of ProcessorInterface, passed ' . get_class($service));
            }

            return $service;
        }
    }

    /**
     * @param array $options
     *
     * @return array
     */
    protected function prepareContextOptions(array $options = [])
    {
        $o = [];
        foreach ($options as $option) {
            $chunk = explode('=', $option);
            if (count($chunk) >= 2) {
                $o[$chunk[0]] = implode('=', array_slice($chunk, 1));
            } else {
                $o[$option] = true;
            }
        }

        return $o;
    }
}
