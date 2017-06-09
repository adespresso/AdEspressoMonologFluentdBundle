<?php

namespace Ae\MonologFluentdBundle\DependencyInjection;

use Fluent\Logger\FluentLogger;
use Monolog\Logger;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     *
     * @throws \RuntimeException
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
                    ->defaultValue([])
                ->end()
                ->scalarNode('level')
                    ->defaultValue(Logger::DEBUG)
                ->end()
            ->end();

        return $treeBuilder;
    }
}
