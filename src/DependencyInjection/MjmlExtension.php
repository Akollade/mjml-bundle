<?php

namespace NotFloran\MjmlBundle\DependencyInjection;

use NotFloran\MjmlBundle\Renderer\BinaryRenderer;
use NotFloran\MjmlBundle\Renderer\RendererInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class MjmlExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);

        $rendererServiceId = null;

        if ('binary' === $config['renderer']) {
            $rendererDefinition = new Definition(BinaryRenderer::class);
            $rendererDefinition->addArgument($config['options']['binary']);
            $rendererDefinition->addArgument($config['options']['minify']);
            $rendererDefinition->addArgument($config['options']['validation_level']);
            $rendererDefinition->addArgument($config['options']['node']);
            $rendererDefinition->addArgument($config['options']['mjml_version']);
            $container->setDefinition($rendererDefinition->getClass(), $rendererDefinition);
            $rendererServiceId = $rendererDefinition->getClass();
        } elseif ('service' === $config['renderer']) {
            $rendererServiceId = $config['options']['service_id'];
        } else {
            throw new \LogicException(sprintf('Unknown renderer "%s"', $config['renderer']));
        }

        $container->setAlias(RendererInterface::class, $rendererServiceId);
        $container->setAlias('mjml', $rendererServiceId);
    }
}
