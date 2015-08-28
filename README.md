# adespresso/monolog-fluentd-bundle

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/adespresso/MonologFluentdBundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/adespresso/MonologFluentdBundle/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/adespresso/MonologFluentdBundle/badges/build.png?b=master)](https://scrutinizer-ci.com/g/adespresso/MonologFluentdBundle/build-status/master)
[![Code Coverage](https://scrutinizer-ci.com/g/adespresso/MonologFluentdBundle/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/adespresso/MonologFluentdBundle/?branch=master)

This bundle enables logging to fluentd via monolog.

Monolog sends your logs to files, sockets, inboxes, databases and various web services.

Fluentd is an open source data collector, it decouples data sources from backend systems by providing a unified logging layer in between.

## Install

    php composer.phar require adespresso/monolog-fluentd-bundle

## Register the bundle in Symfony2

    <?php
    // AppKernel.php

    use Symfony\Component\HttpKernel\Kernel;
    use Symfony\Component\Config\Loader\LoaderInterface;
    
    class AppKernel extends Kernel
    {
        public function registerBundles()
        {
            $bundles = array(
                ...
                new Ae\MonologFluentdBundle\AeMonologFluentdBundle(),
            );
            ...
        }
    }

## Configuration

These are the default parameters: you may change them in config.yml or parameters.yml

    ae_monolog_fluentd:
        host: localhost
        port: 24224
        options: []
        level: debug

You may load the handler as a service

    monolog:
        handlers:
            ae_monolog_fluentd:
                type: service
                id: ae_monolog_fluentd.monolog.handler

## How to run the tests

    phpunit -c phpunit.xml.dist

## Copyright

© 2015 AdEspresso, Inc

## License

Apache 2.0 (see [LICENSE](/LICENSE) file or http://www.apache.org/licenses/LICENSE-2.0)
