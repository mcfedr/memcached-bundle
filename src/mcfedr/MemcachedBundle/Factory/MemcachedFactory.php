<?php
/**
 * Created by mcfedr on 23/05/2014 10:47
 */

namespace mcfedr\MemcachedBundle\Factory;

class MemcachedFactory
{
    /**
     * @param array $servers
     * @param string $persistentId
     * @return \Memcached
     */
    public static function get(array $servers, $persistentId = null) {
        $memcached = new \Memcached($persistentId);
        if (!count($memcached->getServerList())) {
            foreach($servers as $server) {
                $memcached->addServer($server['host'], $server['port']);
            }
        }
        return $memcached;
    }
}
