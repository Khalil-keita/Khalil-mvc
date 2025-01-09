<?php

namespace Khalil\Components\Logger\Interface;

/**
 * Interface pour l'enregistrement des messages avec différents niveaux de sévérité.
 */
interface LoggerInterface
{

    public const LOG_LEVEL_INFO = "INFO";
    public const LOG_LEVEL_ERROR = "ERROR";
    public const LOG_LEVEL_DEBUG = "DEBUG";

    /**
     * Enregistre un message avec un niveau de sévérité spécifié.
     *
     * @param string $message Le message à enregistrer.
     * @param string $level   Le niveau de sévérité (par défaut : INFO).
     */
    private function log(string $message, string $level = self::LOG_LEVEL_INFO): void;

    /**
     * Enregistre un message d'erreur.
     *
     * @param string $message Le message d'erreur à enregistrer.
     */
    public function error(string $message): void;

    /**
     * Enregistre un message de débogage.
     *
     * @param string $message Le message de débogage à enregistrer.
     */
    public function debug(string $message): void;
}
