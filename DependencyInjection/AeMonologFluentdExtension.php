<?php

namespace Ae\MonologFluentdBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

class AeMonologFluentdExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('ae_monolog_fluentd.host', $config['host']);
        $container->setParameter('ae_monolog_fluentd.port', $config['port']);
        $container->setParameter('ae_monolog_fluentd.options', $config['options']);
        $container->setParameter('ae_monolog_fluentd.level', $config['level']);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');
    }
}
