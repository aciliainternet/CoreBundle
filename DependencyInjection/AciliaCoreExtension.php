<?php

namespace Acilia\Bundle\CoreBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class AciliaCoreExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        // Set Default Memcache Prefix
        if (!$container->hasParameter('memcached.prefix')) {
        	$container->setParameter('memcached.prefix', 'acilia-cb');
        }

        // Set Memcache Enabled by Default
        if (!$container->hasParameter('memcached.enabled')) {
        	$container->setParameter('memcached.enabled', true);
        }

        // Set Fragment Cache Disabled by Default
        if (!$container->hasParameter('fragment_cache.enabled')) {
            $container->setParameter('fragment_cache.enabled', false);
        }

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}
