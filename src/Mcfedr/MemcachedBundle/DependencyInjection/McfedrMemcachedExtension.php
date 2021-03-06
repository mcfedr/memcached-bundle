<?php

namespace Mcfedr\MemcachedBundle\DependencyInjection;

use Mcfedr\MemcachedBundle\Factory\MemcachedFactory;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class McfedrMemcachedExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        foreach ($config['connections'] as $name => $connection) {
            $def = new Definition(
                \Memcached::class, [
                    $connection['servers'],
                    isset($connection['persistent_id']) ? $connection['persistent_id'] : null
                ]
            );

            $def->setFactory([MemcachedFactory::class, 'get']);
            $container->setDefinition("mcfedr_memcached.$name", $def);
        }
    }
}
