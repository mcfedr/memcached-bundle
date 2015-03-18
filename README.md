# Memcached Bundle

This is going to be the simplest bundle you have ever seen for memcached

[![Latest Stable Version](https://poser.pugx.org/mcfedr/memcached-bundle/v/stable.png)](https://packagist.org/packages/mcfedr/memcached-bundle)
[![License](https://poser.pugx.org/mcfedr/memcached-bundle/license.png)](https://packagist.org/packages/mcfedr/memcached-bundle)
[![Build Status](https://travis-ci.org/mcfedr/memcached-bundle.svg?branch=master)](https://travis-ci.org/mcfedr/memcached-bundle)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/12ae7a3f-afd2-44be-9745-2bb9d015cfe1/mini.png)](https://insight.sensiolabs.com/projects/12ae7a3f-afd2-44be-9745-2bb9d015cfe1)

## Install

* `composer require mcfedr/memcached-bundle`

* Update your Kernel

    `new Mcfedr\MemcachedBundle\McfedrMemcachedBundle()`

## Configuration

You can setup as many memcached connections as you need, although most of the time one is enough.
You need to have at least one server for each connection.

Optionally you can make a connection persistent, this is recommended for better performance.

    mcfedr_memcached:
        connections:
            main:
                persistent_id: main
                servers:
                    - host: 127.0.0.1
                      port: 11211
            other:
                servers:
                    - host: 10.0.0.10
                      port: 11211
                    - host: 10.0.0.11
                      port: 11211
                    - host: 10.0.0.12
                      port: 11211

Each connection will be available as a service called `"mcfedr_memcached.$name"`.
So in the example there are two services:

1. `mcfedr_memcached.main`
1. `mcfedr_memcached.other`
