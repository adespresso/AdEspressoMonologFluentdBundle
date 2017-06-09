<?php

namespace Ae\MonologFluentdBundle\DependencyInjection;

use Monolog\Logger;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class AeMonologFluentdExtension extends Extension
{
    /**
     * {@inheritdoc}
     *
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        // Converts PSR-3 levels to Monolog ones if necessary
        $config['level'] = Logger::toMonologLevel($config['level']);

        $container->setParameter('ae_monolog_fluentd.host', $config['host']);
        $container->setParameter('ae_monolog_fluentd.port', $config['port']);
        $container->setParameter('ae_monolog_fluentd.options', $config['options']);
        $container->setParameter('ae_monolog_fluentd.level', $config['level']);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');
    }
}
