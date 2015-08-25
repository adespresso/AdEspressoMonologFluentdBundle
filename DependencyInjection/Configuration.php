<?php

namespace Ae\MonologFluentdBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Fluent\Logger\FluentLogger;
use Monolog\Logger;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('ae_monolog_fluentd');

        $rootNode
            ->children()
                ->scalarNode('host')
                    ->defaultValue(FluentLogger::DEFAULT_ADDRESS)
                ->end()
                ->scalarNode('port')
                    ->defaultValue(FluentLogger::DEFAULT_LISTEN_PORT)
                ->end()
                ->variableNode('options')
                    ->defaultValue(array())
                ->end()
                ->scalarNode('level')
                    ->defaultValue(Logger::DEBUG)
                ->end()
            ->end();

        return $treeBuilder;
    }
}
