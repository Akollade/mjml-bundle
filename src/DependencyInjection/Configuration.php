<?php

namespace NotFloran\MjmlBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Process\ExecutableFinder;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('mjml');
        if (\method_exists($treeBuilder, 'getRootNode')) {
            $rootNode = $treeBuilder->getRootNode();
        } else {
            // BC layer for symfony/config 4.1 and older
            $rootNode = $treeBuilder->root('mjml');
        }

        $finder = new ExecutableFinder();

        $rootNode
            ->children()
                ->enumNode('renderer')
                    ->values(['binary', 'service'])
                    ->defaultValue('binary')
                ->end()
                ->arrayNode('options')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('binary')
                            ->defaultValue(function () use ($finder) {
                                return $finder->find('mjml');
                            })
                            ->info('Path to the binary')
                        ->end()
                        ->scalarNode('service_id')
                            ->info('Service id when renderer is defined to "service"')
                        ->end()
                        ->booleanNode('minify')
                            ->defaultFalse()
                        ->end()
                    ->end()
                ->end()
            ->end()
            ->validate()
            ->ifTrue(function($config) {
                $emptyBinary = $config['renderer'] === 'binary' and empty($config['options']['binary']);
                $missingService = $config['renderer'] === 'service' and !isset($config['options']['service_id']);

                return $emptyBinary || $missingService;
            })
            ->then(function($config) {
                if ($config['renderer'] === 'service' and !isset($config['options']['service_id'])) {
                    throw new \LogicException('"service_id" is missing for service renderer');
                }

                if ($config['renderer'] === 'binary' and empty($config['options']['binary'])) {
                    throw new \LogicException('Binary is missing');
                }

                return $config;
            })
            ->end()
        ;

        return $treeBuilder;
    }
}
