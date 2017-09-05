<?php

namespace NotFloran\MjmlBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('mjml');

        $rootNode
            ->children()
                ->scalarNode('bin')
                    ->defaultValue('mjml')
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
