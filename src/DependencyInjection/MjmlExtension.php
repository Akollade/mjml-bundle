<?php

namespace NotFloran\MjmlBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;

class MjmlExtension extends Extension
{
    /**
     * Loads the Swift Mailer configuration.
     *
     * Usage example:
     *
     *      <swiftmailer:config transport="gmail">
     *        <swiftmailer:username>fabien</swift:username>
     *        <swiftmailer:password>xxxxx</swift:password>
     *        <swiftmailer:spool path="/path/to/spool/" />
     *      </swiftmailer:config>
     *
     * @param array            $configs   An array of configuration settings
     * @param ContainerBuilder $container A ContainerBuilder instance
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('notfloran_mjml.bin', $config['bin']);
        $container->setParameter('notfloran_mjml.mimify', $config['mimify']);
    }

}
