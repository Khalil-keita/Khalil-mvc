<?php

use Khalil\Components\Logger\Interface\LoggerInterface;

/**
 * Enregistre les messages dans un fichier.
 */
class FileLogger implements  LoggerInterface
{

    /**
     * Constructeur de FileLogger.
     *
     * @param string $logFile Le chemin du fichier de log.
     */
    public function __construct(private readonly string $logFile){}

    /**
     * {@inheritdoc}
     */
    private function log(string $message, string $level = LoggerInterface::LOG_LEVEL_INFO): void
    {
        $entry = sprintf('[%s] [%s] %s%s', date('Y-m-d H:i:s'), $level, $message, PHP_EOL);
        file_put_contents($this->logFile, $entry, FILE_APPEND);
    }

    /**
     * {@inheritdoc}
     */
    public function error(string $message): void
    {
        $this->log($message, LoggerInterface::LOG_LEVEL_ERROR);
    }

    /**
     * {@inheritdoc}
     */
    public function debug(string $message): void
    {
        $this->log($message, LoggerInterface::LOG_LEVEL_DEBUG);
    }
}
