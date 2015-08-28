<?php

namespace Ae\MonologFluentdBundle\Tests\DependencyInjection;

use Ae\MonologFluentdBundle\DependencyInjection\AeMonologFluentdExtension;
use Monolog\Logger;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Yaml\Parser;

class AeMonologFluentdExtensionTest extends \PHPUnit_Framework_TestCase
{
    /** @var AeMonologFluentdExtension */
    protected $loader;

    public function setUp()
    {
        $this->loader = new AeMonologFluentdExtension();
        $this->container = new ContainerBuilder();
    }

    public function testParameterHost()
    {
        $this->loader->load($this->getConfig(), $this->container);
        $this->assertParameter('localhost', 'ae_monolog_fluentd.host');
    }

    public function testParameterPort()
    {
        $this->loader->load($this->getConfig(), $this->container);
        $this->assertParameter(24224, 'ae_monolog_fluentd.port');
    }

    public function testParameterOptions()
    {
        $this->loader->load($this->getConfig(), $this->container);
        $this->assertParameter([], 'ae_monolog_fluentd.options');
    }

    public function testParameterLevelAsInt()
    {
        $config = $this->getConfig();
        $config['ae_monolog_fluentd']['level'] = Logger::DEBUG;
        $this->loader->load($config, $this->container);
        $this->assertParameter(Logger::DEBUG, 'ae_monolog_fluentd.level');
    }

    public function testParameterLevelAsString()
    {
        $config = $this->getConfig();
        $config['ae_monolog_fluentd']['level'] = 'dEbUg';
        $this->loader->load($config, $this->container);
        $this->assertParameter(Logger::DEBUG, 'ae_monolog_fluentd.level');
    }

    public function assertParameter($value, $key)
    {
        $this->assertEquals($value, $this->container->getParameter($key));
    }

    protected function getConfig()
    {
        $yaml = <<<EOF
ae_monolog_fluentd:
    host: localhost
    port: 24224
    options: []
    level: debug
EOF;
        $parser = new Parser();

        return $parser->parse($yaml);
    }
}
