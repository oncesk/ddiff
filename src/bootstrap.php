<?php

require __DIR__.'/../vendor/autoload.php';

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\EventDispatcher\DependencyInjection\RegisterListenersPass;
use Symfony\Component\EventDispatcher\EventDispatcher;

$container = new ContainerBuilder();
$container->addCompilerPass(new RegisterListenersPass());
$container->register('event_dispatcher', EventDispatcher::class);

$container->setParameter('root', __DIR__);
$container->setParameter('conf.root', __DIR__ . '/conf');

$loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/resources/config'));
$loader->load('parameters.yml');
$loader->load('services.yml');

$container->compile();

return $container;