<?php

namespace mcfedr\MemcachedBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class mcfedrMemcachedExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        foreach($config['connections'] as $name => $connection)
        {
            $container->setDefinition("mcfedr_memcached.$name", new Definition('Memcached', [
                'factory' => 'mcfedr\MemcachedBundle\Factory\MemcachedFactory',
                'factory_method' => 'get',
                'arguments' => [
                    $connection['servers'],
                    isset($connection['persistent_id']) ? $connection['persistent_id'] : null
                ]
            ]));
        }
    }
}
