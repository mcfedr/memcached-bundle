<?php
/**
 * Created by mcfedr on 23/05/2014 11:09
 */

namespace Mcfedr\MemcachedBundle\Tests\Factory;

use Mcfedr\MemcachedBundle\Factory\MemcachedFactory;

class MemcachedFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Check we create an instance of memcached
     */
    public function testGet()
    {
        $memcached = MemcachedFactory::get([]);
        $this->assertInstanceOf('Memcached', $memcached);
    }

    /*
     * Check that we can add a server
     */
    public function testServer()
    {
        $memcached = MemcachedFactory::get(
            [
                [
                    'host' => 'localhost',
                    'port' => 11211
                ]
            ]
        );
        $servers = $memcached->getServerList();
        $this->assertCount(1, $servers);
        $this->assertEquals('localhost', $servers[0]['host']);
        $this->assertEquals('11211', $servers[0]['port']);
    }

    /**
     * Check that we can add multiple servers
     */
    public function testServers()
    {
        $memcached = MemcachedFactory::get(
            [
                [
                    'host' => 'localhost',
                    'port' => 11211
                ],
                [
                    'host' => 'localhost',
                    'port' => 11211
                ]
            ]
        );
        $servers = $memcached->getServerList();
        $this->assertCount(2, $servers);
        $this->assertEquals('localhost', $servers[1]['host']);
        $this->assertEquals('11211', $servers[1]['port']);
    }

    /**
     * Check that we can create a persistent connection
     */
    public function testPersistent()
    {
        $memcached = MemcachedFactory::get([], __FUNCTION__);
        $this->assertTrue($memcached->isPersistent());
    }

    /**
     * Check that we don't re-add servers to a persistent connection
     */
    public function testPersistentServers()
    {
        $memcached = MemcachedFactory::get(
            [
                [
                    'host' => 'localhost',
                    'port' => 11211
                ]
            ],
            __FUNCTION__
        );
        $memcached2 = MemcachedFactory::get(
            [
                [
                    'host' => 'localhost',
                    'port' => 11211
                ]
            ],
            __FUNCTION__
        );

        $this->assertCount(1, $memcached->getServerList());
        $this->assertCount(count($memcached->getServerList()), $memcached2->getServerList());
    }

    /**
     * Check that we can have separate persistent connections
     */
    public function testMultiplePersistent()
    {
        $memcached = MemcachedFactory::get([[
                'host' => 'localhost',
                'port' => 11211
            ]], __FUNCTION__);

        $memcached2 = MemcachedFactory::get([], __FUNCTION__ . '2');

        $this->assertCount(0, $memcached2->getServerList());
    }
}
