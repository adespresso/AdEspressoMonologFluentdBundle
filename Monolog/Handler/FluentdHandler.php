<?php

namespace Ae\MonologFluentdBundle\Monolog\Handler;

use Fluent\Logger\FluentLogger;
use Monolog\Formatter\JsonFormatter;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;

class FluentdHandler extends AbstractProcessingHandler
{
    /**
     * @var FluentLogger
     */
    protected $fluentLogger;

    /**
     * Initialize Handler.
     *
     * @param string $host
     * @param int    $port
     * @param array  $options FluentLogger options
     * @param int    $level   The minimum logging level at which this handler will be triggered
     * @param bool   $bubble  Whether the messages that are handled can bubble up the stack or not
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(
        $level = Logger::DEBUG,
        $bubble = true,
        $host = FluentLogger::DEFAULT_ADDRESS,
        $port = FluentLogger::DEFAULT_LISTEN_PORT,
        $options = []
    ) {
        parent::__construct($level, $bubble);
        $this->fluentLogger = $this->makeFluentLogger($host, $port, $options);

        // By default FluentLogger would write to stderr for every message gone wrong.
        // We find it a bad default (you would probably start to log myriad of data as error).
        // You can reset the same or a different error handler by accessing the logger with getFluentLogger();
        $this->fluentLogger->registerErrorHandler(function ($logger, $entity, $error) {});
    }

    /**
     * Get the internal FluentLogger instance.
     *
     * @return FluentLogger
     */
    public function getFluentLogger()
    {
        return $this->fluentLogger;
    }

    /**
     * {@inheritdoc}
     */
    public function close()
    {
        $this->fluentLogger->close();
    }

    /**
     * Create a new instance of FluentLogger.
     *
     * @param string $host
     * @param int    $port
     * @param array  $options FluentLogger options
     *
     * @return FluentLogger
     */
    protected function makeFluentLogger($host, $port, array $options = [])
    {
        return new FluentLogger($host, $port, $options);
    }

    /**
     * {@inheritdoc}
     */
    protected function write(array $record)
    {
        $this->fluentLogger->post($this->formatTag($record), $record['context']);
    }

    /**
     * Format a fluentd tag using the record data.
     *
     * @param array $record
     *
     * @return string the tag
     */
    protected function formatTag(array $record)
    {
        return sprintf('%s.%s', $record['channel'], $record['message']);
    }

    /**
     * @return \Monolog\Formatter\FormatterInterface
     */
    protected function getDefaultFormatter()
    {
        return new JsonFormatter();
    }
}
