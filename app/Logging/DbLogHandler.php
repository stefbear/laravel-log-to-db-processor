<?php

namespace App\Logging;

use App\Models\Log;
use Monolog\Logger;
use Monolog\Formatter\FormatterInterface;
use Monolog\Handler\AbstractProcessingHandler;

class DbLogHandler extends AbstractProcessingHandler
{
    public function __construct($level = Logger::DEBUG)
    {
        parent::__construct($level);
    }

    protected function write(array $record): void
    {
        // Simple store implementation
        $log = new Log();
        $log->fill($record['formatted']);
        $log->save();
    }

    /**
     * {@inheritDoc}
     */
    protected function getDefaultFormatter(): FormatterInterface
    {
        return new DbLogFormatter();
    }
}
