<?php

namespace DDiff\Command\DataBase;

use DDiff\Configuration\Storage\StorageInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * Class CreateConfigurationCommand
 * @package DDiff\Command\DataBase
 */
class CreateConfigurationCommand extends Command implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    protected function configure()
    {
        $this
            ->setName('ddiff:db:config:create')
            ->setDescription('Create database configuration')
            ->addArgument('user', InputArgument::REQUIRED, 'Database username')
            ->addArgument('password', InputArgument::REQUIRED, 'Database password')
            ->addArgument('database', InputArgument::REQUIRED, 'Database for use')
            ->addArgument('name', InputArgument::REQUIRED, 'Configuration name')

            ->addOption('host', 'H', InputOption::VALUE_OPTIONAL, 'Database host', 'localhost')
            ->addOption('port', 'p', InputOption::VALUE_OPTIONAL, 'Database port', 3306)
            ->addOption('driver', 'driver', InputOption::VALUE_OPTIONAL, 'Database driver [mysql]', 'mysql')
            ->addOption('charset', 'cs', InputOption::VALUE_OPTIONAL, 'Connection charset', 'utf8')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $options = ['host', 'port', 'driver', 'charset'];
        $arguments = ['user', 'password', 'database'];
        $config = [];

        foreach ($arguments as $argument) {
            $config[$argument] = $input->getArgument($argument);
        }

        foreach ($options as $option) {
            $config[$option] = $input->getOption($option);
        }

        $this->getStorage()->save($input->getArgument('name'), json_encode($config));
    }

    /**
     * @return StorageInterface
     */
    protected function getStorage()
    {
        return $this->container->get('configuration.db.storage');
    }
}
