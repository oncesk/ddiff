<?php

namespace DDiff\Command\DataBase;

use DDiff\Configuration\Storage\StorageInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * Class ConfigurationListCommand
 * @package DDiff\Command\DataBase
 */
class ConfigurationListCommand extends Command implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    protected function configure()
    {
        $this
            ->setName('ddiff:db:config:show')
            ->setDescription('Show configurations')
            ->addOption('charset', 'c', InputOption::VALUE_NONE, 'Display charset')
            ->addOption('source-config', null, InputOption::VALUE_NONE, 'Display source configuration key for diff')
            ->addOption('destination-config', null, InputOption::VALUE_NONE, 'Display destination configuration key for diff')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $storage = $this->getStorage();
        $configs = $storage->getConfigurations('db.*.json');
        $table = new Table($output);
        $fields = [
            'Name',
            'Driver',
            'Host',
            'Port',
            'Username',
            'Database',
        ];
        if ($input->getOption('charset')) {
            $fields[] = 'Charset';
        }
        if ($input->getOption('source-config')) {
            $fields[] = 'Src config';
        }
        if ($input->getOption('destination-config')) {
            $fields[] = 'Destination config';
        }

        $table->setHeaders($fields);
        foreach ($configs as $config) {
            if (preg_match('/db\.([\w+\_\.\-]+)\.json$/', basename($config), $matches)) {
                $json = json_decode($storage->load($matches[1]), true);
                if (JSON_ERROR_NONE === json_last_error()) {
                    $row = [
                        $matches[1],
                        $json['driver'],
                        $json['host'],
                        $json['port'],
                        $json['user'],
                        $json['database'],
                    ];
                    if ($input->getOption('charset')) {
                        $row[] = $json['charset'];
                    }
                    if ($input->getOption('source-config')) {
                        $row[] = '-c db.src.config=' . $matches[1];
                    }
                    if ($input->getOption('destination-config')) {
                        $row[] = '-c db.dst.config=' . $matches[1];
                    }
                    $table->addRow($row);
                }
            }
        }

        $output->writeln('Database configurations');
        $table->render();
    }

    /**
     * @return StorageInterface
     */
    protected function getStorage()
    {
        return $this->container->get('configuration.db.storage');
    }
}
