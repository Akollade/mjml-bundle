<?php

namespace NotFloran\MjmlBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Process\ExecutableFinder;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('mjml');

        $finder = new ExecutableFinder();

        $rootNode
            ->children()
                ->enumNode('renderer')
                    ->values(array('binary'))
                    ->defaultValue('binary')
                ->end()
                ->arrayNode('options')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('binary')->defaultValue(function () use ($finder) {
                            return $finder->find('mjml');
                        })
                        ->info('Path to the binary')->end()
                        ->booleanNode('minify')->defaultFalse()->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
