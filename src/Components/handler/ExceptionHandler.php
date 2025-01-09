<?php
namespace Khalil\Components\Handler;

use Khalil\Components\Logger\Interface\LoggerInterface;
use Throwable;

/**
 * Gère les exceptions non capturées et les erreurs PHP, en les enregistrant correctement.
 */
class ExceptionHandler
{

    /**
     * Constructeur de ExceptionHandler.
     *
     * @param LoggerInterface $logger Instance du logger pour enregistrer les erreurs et exceptions.
     * @param bool            $debug  Indique si le mode débogage est activé.
     */
    public function __construct(private LoggerInterface $logger, private bool $debug){}

    /**
     * Enregistre les gestionnaires d'exception et d'erreur.
     *
     * @return void
     */
    public function register(): void
    {
        set_exception_handler($this->handleException(...));
        set_error_handler($this->handleError(...));
    }

    /**
     * Gère les exceptions non capturées.
     *
     * @param Throwable $exception L'exception non capturée.
     * @return void
     */
    public function handleException(Throwable $exception): void
    {
        $message = sprintf(
            'Exception non capturée : %s dans %s:%d',
            $exception->getMessage(),
            $exception->getFile(),
            $exception->getLine()
        );
        $this->logger->error($message);

        if ($this->debug) {
            echo '<h1>500 - Erreur interne du serveur</h1>';
            echo '<pre>' . $exception . '</pre>';
        } else {
            http_response_code(500);
            echo '<h1>500 - Erreur interne du serveur</h1>';
        }
    }

    /**
     * Gère les erreurs PHP.
     *
     * @param int    $severity Le niveau de l'erreur générée.
     * @param string $message  Le message d'erreur.
     * @param string $file     Le fichier où l'erreur a été générée.
     * @param int    $line     Le numéro de ligne où l'erreur a été générée.
     * @return bool Retourne vrai pour indiquer que l'erreur a été traitée.
     */
    public function handleError(int $severity, string $message, string $file, int $line): bool
    {
        $logMessage = sprintf('Erreur : [%d] %s dans %s:%d', $severity, $message, $file, $line);
        $this->logger->error($logMessage);

        if ($this->debug) {
            echo '<h1>Une erreur s\'est produite</h1>';
            echo "<p>Erreur : [$severity] $message dans $file:$line</p>";
        } else {
            http_response_code(500);
            echo '<h1>500 - Erreur interne du serveur</h1>';
        }

        return true;
    }
}
