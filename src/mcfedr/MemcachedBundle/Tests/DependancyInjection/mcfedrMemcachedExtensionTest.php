<?php
/**
 * Created by mcfedr on 23/05/2014 16:15
 */

namespace mcfedr\MemcachedBundle\Tests\DependancyInjection;

use mcfedr\MemcachedBundle\DependencyInjection\mcfedrMemcachedExtension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class mcfedrMemcachedExtensionTest extends \PHPUnit_Framework_TestCase
{
    private $container;

    public function setUp()
    {
        $this->container = new ContainerBuilder();
        $this->container->registerExtension(new mcfedrMemcachedExtension());
        $loader = new YamlFileLoader($this->container, new FileLocator(__DIR__));
        $loader->load('test.yml');

        $this->container->compile();
    }

    public function testService()
    {
        $this->assertInstanceOf('Memcached', $this->container->get('mcfedr_memcached.main'));
    }

    public function testServicePersistent()
    {
        $this->assertTrue($this->container->get('mcfedr_memcached.main')->isPersistent());
        $this->assertFalse($this->container->get('mcfedr_memcached.other')->isPersistent());
    }

    public function testServiceServers()
    {
        $this->assertCount(1, $this->container->get('mcfedr_memcached.main')->getServerList());
        $this->assertCount(3, $this->container->get('mcfedr_memcached.other')->getServerList());
    }
} 