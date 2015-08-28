# adespresso/monolog-fluentd-bundle

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
