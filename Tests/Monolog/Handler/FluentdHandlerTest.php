<?php

namespace Ae\MonologFluentdBundle\Tests\Monolog\Handler;

use Ae\MonologFluentdBundle\Monolog\Handler\FluentdHandler;
use Fluent\Logger\FluentLogger;
use Monolog\Logger;

class FluentdHandlerTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->fluentLoggerMock = $this->getMockBuilder(FluentLogger::class)
        ->disableOriginalConstructor()
        ->getMock();
    }

    public function testHandle()
    {
        $handler = $this->createHandlerInstance();

        $message = 'a.b.c';
        $context = ['x' => 1];
        $record = $this->getRecord(Logger::WARNING, $message, $context);

        $this->fluentLoggerMock->expects($this->once())
            ->method('post')
            ->with('test.a.b.c', $context);

        $handler->handle($record);
    }

    public function testHandleBatchNotWritesToFluentdIfMessagesAreBelowLevel()
    {
        $records = array(
            $this->getRecord(Logger::DEBUG, 'debug message 1'),
            $this->getRecord(Logger::DEBUG, 'debug message 2'),
            $this->getRecord(Logger::INFO, 'information'),
        );

        $handler = $this->createHandlerInstance();
        $handler->setLevel(Logger::ERROR);

        $this->fluentLoggerMock->expects($this->never())
        ->method('post');

        $handler->handleBatch($records);
    }

    /**
     * Create an instance with default args and `makeFluentLogger` mocked
     */
    private function createHandlerInstance()
    {
        $hostname = 'foo';
        $port = 1234;
        $options = ['bar' => 'baz'];

        $fluentdHandlerMock = $this->getMockBuilder(FluentdHandler::class)
        ->setMethods(array('makeFluentLogger'))
        ->disableOriginalConstructor()
        ->getMock();

        $fluentdHandlerMock->expects($this->once())
        ->method('makeFluentLogger')
        ->willReturn($this->fluentLoggerMock);

        $fluentdHandlerMock->__construct($hostname, $port, $options);

        return $fluentdHandlerMock;
    }

    protected function getRecord($level = Logger::WARNING, $message = 'test', $context = [])
    {
        return [
            'message' => $message,
            'context' => $context,
            'level' => $level,
            'level_name' => Logger::getLevelName($level),
            'channel' => 'test',
            'datetime' => \DateTime::createFromFormat('U.u', sprintf('%.6F', microtime(true))),
            'extra' => [],
        ];
    }
}