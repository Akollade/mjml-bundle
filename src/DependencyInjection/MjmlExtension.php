<?php

namespace NotFloran\MjmlBundle\DependencyInjection;

use NotFloran\MjmlBundle\Renderer\BinaryRenderer;
use NotFloran\MjmlBundle\Renderer\RendererInterface;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;

class MjmlExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);

        $rendererDefinition = new Definition();

        if ($config['renderer'] === 'binary') {
            $rendererDefinition->setClass(BinaryRenderer::class);
            $rendererDefinition->addArgument($config['options']['binary']);
            $rendererDefinition->addArgument($config['options']['minify']);
        } else if ($config['renderer'] === 'api') {

        }

        $container->setDefinition(BinaryRenderer::class, $rendererDefinition);
        $container->setAlias(RendererInterface::class, $rendererDefinition->getClass());
        $container->setAlias('mjml', $rendererDefinition->getClass());
    }
}
