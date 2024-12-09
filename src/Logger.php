<?php

declare(strict_types=1);
namespace App;

use Monolog\Logger as MonologLogger;
use Monolog\Handler\StreamHandler;

class Logger
{
    private static ?MonologLogger $logger = null;

    /**
     * get logger
     * @return MonologLogger
     */
    public static function getLogger(): MonologLogger
    {
        if (self::$logger === null) {
            self::$logger = new MonologLogger('neuffer.test_task');
            self::$logger->pushHandler(
                new StreamHandler(__DIR__ . '/../logs/' . date('d.m.Y') . '_logs.log', MonologLogger::DEBUG)
            );
        }

        return self::$logger;
    }

    /**
     * get log file path
     * @return string
     */
    public static function getLogFilePath() : string
    {
        return __DIR__ . '/../logs/' . date('d.m.Y') . '_logs.log';
    }

}