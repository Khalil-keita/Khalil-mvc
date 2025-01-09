<?php
namespace Khalil\Components\Container\Interface;

/**
 * Interface pour un conteneur d'injection de dépendances.
 */
interface ContainerInterface
{
    /**
     * Enregistre un service dans le conteneur.
     *
     * @param string   $name      Le nom du service.
     * @param callable $callback  La fonction ou la classe qui crée l'instance du service.
     * @param bool     $singleton Indique si le service est un singleton.
     */
    public function set(string $name, callable|string $callback, bool $singleton = false): void;

    /**
     * Récupère un service à partir du conteneur.
     *
     * @param string $name Le nom du service.
     * @return mixed L'instance du service.
     * @throws \Exception Si le service n'est pas trouvé.
     */
    public function get(string $name);

    /**
     * Vérifie si un service existe dans le conteneur.
     *
     * @param string $name Le nom du service.
     * @return bool True si le service existe, sinon false.
     */
    public function has(string $name): bool;
}
