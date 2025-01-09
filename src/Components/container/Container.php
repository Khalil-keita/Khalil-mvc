<?php
namespace Khalil\Components\Container;

use Khalil\Components\Container\Interface\ContainerInterface;
use Exception;
use ReflectionClass;


/**
 * Conteneur d'injection de dépendances amélioré.
 * Gère l'enregistrement et la résolution des services, y compris les singletons et la résolution automatique des dépendances.
 */
class Container implements ContainerInterface
{
    /**
     * @var array Liste des services enregistrés avec leurs callbacks et leurs configurations.
     */
    private array $services = [];

    /**
     * @var array Instances des services enregistrés en tant que singletons.
     */
    private array $instances = [];

    /**
     * Enregistre un service dans le conteneur.
     *
     * @param string   $name      Le nom unique du service.
     * @param callable|string $callback  La fonction ou le nom de la classe qui crée le service.
     * @param bool     $singleton Indique si le service doit être un singleton.
     */
    public function set(string $name, callable|string $callback, bool $singleton = false): void
    {
        $this->services[$name] = [
            'callback' => $callback,
            'singleton' => $singleton,
        ];
    }

    /**
     * Récupère un service à partir du conteneur.
     *
     * @param string $name Le nom du service à récupérer.
     * @return mixed L'instance du service.
     * @throws Exception Si le service n'est pas enregistré.
     */
    public function get(string $name)
    {
        // Si le service est un singleton déjà instancié, retourne l'instance.
        if (isset($this->instances[$name])) {
            return $this->instances[$name];
        }

        // Vérifie si le service est enregistré.
        if (!isset($this->services[$name])) {
            throw new Exception("Service '$name' non trouvé.");
        }

        // Résout le service.
        $service = $this->services[$name];
        $instance = $this->resolve($service['callback']);

        // Si le service est un singleton, stocke l'instance.
        if ($service['singleton']) {
            $this->instances[$name] = $instance;
        }

        return $instance;
    }

    /**
     * Résout un service en exécutant son callback ou en instanciant une classe.
     *
     * @param callable|string $callback La fonction ou le nom de la classe à résoudre.
     * @return object L'instance du service.
     * @throws Exception Si une dépendance ne peut pas être résolue.
     */
    private function resolve(callable|string $callback)
    {
        // Si le callback est une classe (chaîne), utilise resolveClass.
        if (is_string($callback)) {
            return $this->resolveClass($callback);
        }

        // Si le callback est une fonction, l'exécute.
        return $callback($this);
    }

    /**
     * Résout les dépendances d'une classe en analysant son constructeur.
     *
     * @param string $class Le nom de la classe à instancier.
     * @return object L'instance de la classe avec ses dépendances résolues.
     * @throws Exception Si une dépendance ne peut pas être résolue.
     */
    private function resolveClass(string $class)
    {
        // Réflexion pour analyser la classe.
        $reflection = new ReflectionClass($class);

        // Si la classe n'a pas de constructeur, instancie directement.
        if (!$reflection->hasMethod('__construct')) {
            return new $class();
        }

        $constructor = $reflection->getConstructor();
        $parameters = $constructor->getParameters();

        // Si le constructeur n'a pas de paramètres, instancie directement.
        if (count($parameters) === 0) {
            return new $class();
        }

        // Résout les dépendances des paramètres du constructeur.
        $dependencies = [];
        foreach ($parameters as $parameter) {
            $dependency = $parameter->getType() ? $parameter->getType()->getName() : null;
            if ($dependency === null) {
                throw new Exception("Impossible de résoudre la dépendance de '{$parameter->getName()}' dans le constructeur de '{$class}'");
            }

            // Récupère le service pour chaque dépendance.
            $dependencies[] = $this->get($dependency);
        }

        // Instancie la classe avec ses dépendances.
        return $reflection->newInstanceArgs($dependencies);
    }

    /**
     * Vérifie si un service existe dans le conteneur.
     *
     * @param string $name Le nom du service.
     * @return bool True si le service est enregistré, sinon false.
     */
    public function has(string $name): bool
    {
        return isset($this->services[$name]);
    }
}
