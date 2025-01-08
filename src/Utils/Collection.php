<?php
namespace Khalil\Utils; 

use Countable;
use IteratorAggregate;
use ArrayAccess;
use ArrayIterator;

/**
 * Class Collection
 * 
 * Cette classe représente une collection d'éléments avec des fonctionnalités avancées pour les manipuler.
 * Elle permet des opérations comme l'ajout, la suppression, le filtrage, le tri, et bien plus encore.
 * Elle supporte les clés en chaîne de caractères ou entières, comme un tableau associatif.
 */
class Collection implements Countable, IteratorAggregate, ArrayAccess
{
    /**
     * @var array La collection d'éléments
     */
    private array $items = [];

    /**
     * DataCollection constructor.
     * 
     * Initialiser la collection avec des éléments, qui peuvent être un tableau associatif ou indexé.
     *
     * @param array $items Les éléments à ajouter à la collection.
     */
    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    /**
     * Retourne le nombre d'éléments dans la collection.
     *
     * @return int Le nombre d'éléments dans la collection.
     */
    public function count(): int
    {
        return count($this->items);
    }

    /**
     * Retourne un itérateur pour parcourir la collection.
     *
     * @return ArrayIterator L'itérateur pour la collection.
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->items);
    }

    /**
     * Vérifie si une clé existe dans la collection.
     *
     * @param int|string $offset La clé à vérifier.
     * @return bool Vrai si la clé existe, sinon faux.
     */
    public function offsetExists(int|string $offset): bool
    {
        return array_key_exists($offset, $this->items);
    }

    /**
     * Accède à un élément par sa clé.
     *
     * @param int|string $offset La clé de l'élément à récupérer.
     * @return mixed La valeur associée à la clé ou null si la clé n'existe pas.
     */
    public function offsetGet(int|string $offset): mixed
    {
        return $this->items[$offset] ?? null;
    }

    /**
     * Modifie un élément ou ajoute un nouvel élément à la collection.
     *
     * @param int|string $offset La clé de l'élément à modifier.
     * @param mixed $value La valeur à assigner.
     */
    public function offsetSet(int|string $offset, mixed $value): void
    {
        if ($offset === null) {
            $this->items[] = $value;
        } else {
            $this->items[$offset] = $value;
        }
    }

    /**
     * Supprime un élément par sa clé.
     *
     * @param int|string $offset La clé de l'élément à supprimer.
     */
    public function offsetUnset(int|string $offset): void
    {
        unset($this->items[$offset]);
    }

    /**
     * Ajoute un élément à la collection.
     *
     * @param mixed $item L'élément à ajouter.
     * @return self La collection mise à jour.
     */
    public function add(mixed $item): self
    {
        $this->items[] = $item;
        return $this;
    }

    /**
     * Ajoute un élément à une position spécifique dans la collection.
     *
     * @param int|string $key La clé où ajouter l'élément.
     * @param mixed $item L'élément à ajouter.
     * @return self La collection mise à jour.
     */
    public function addAt(int|string $key, mixed $item): self
    {
        $this->items[$key] = $item;
        return $this;
    }

    /**
     * Supprime un élément par sa clé.
     *
     * @param int|string $key La clé de l'élément à supprimer.
     * @return self La collection mise à jour.
     */
    public function remove(int|string $key): self
    {
        unset($this->items[$key]);
        return $this;
    }

    /**
     * Vérifie si une clé existe dans la collection.
     *
     * @param int|string $key La clé à vérifier.
     * @return bool Vrai si la clé existe, sinon faux.
     */
    public function hasKey(int|string $key): bool
    {
        return array_key_exists($key, $this->items);
    }

    /**
     * Vérifie si une valeur existe dans la collection.
     *
     * @param mixed $value La valeur à vérifier.
     * @return bool Vrai si la valeur existe, sinon faux.
     */
    public function hasValue(mixed $value): bool
    {
        return in_array($value, $this->items, true);
    }

    /**
     * Vérifie si la clé ou la valeur existe dans la collection.
     *
     * @param mixed $item La clé ou la valeur à vérifier.
     * @return bool Vrai si la clé ou la valeur existe, sinon faux.
     */
    public function has(mixed $item): bool
    {
        return $this->hasKey($item) || $this->hasValue($item);
    }

    /**
     * Recherche la clé d'une valeur dans la collection.
     *
     * @param mixed $value La valeur à rechercher.
     * @return int|string|null La clé de la valeur, ou null si elle n'existe pas.
     */
    public function search(mixed $value): int|string|null
    {
        return array_search($value, $this->items, true);
    }

    /**
     * Filtre la collection en fonction d'un callback.
     *
     * @param callable $callback La fonction de filtrage.
     * @return self Une nouvelle collection avec les éléments filtrés.
     */
    public function filter(callable $callback): self
    {
        $filteredItems = array_filter($this->items, $callback);
        return new self(array_values($filteredItems));
    }

    /**
     * Trie la collection en fonction d'un callback.
     *
     * @param callable $callback La fonction de tri.
     * @return self Une nouvelle collection triée.
     */
    public function sort(callable $callback): self
    {
        $sortedItems = $this->items;
        usort($sortedItems, $callback);
        return new self($sortedItems);
    }

    /**
     * Fusionne la collection actuelle avec une autre collection.
     *
     * @param self $collection La collection à fusionner.
     * @return self Une nouvelle collection résultant de la fusion.
     */
    public function merge(self $collection): self
    {
        $mergedItems = array_merge($this->items, $collection->toArray());
        return new self($mergedItems);
    }

    /**
     * Convertit la collection en un tableau.
     *
     * @return array Le tableau des éléments de la collection.
     */
    public function toArray(): array
    {
        return $this->items;
    }

    /**
     * Convertit un élément en entier.
     *
     * @param int|string $key La clé de l'élément.
     * @return int|null La valeur convertie en entier, ou null si la clé n'existe pas.
     */
    public function castToInt(int|string $key): int|null
    {
        return $this->hasKey($key) ? (int) $this->items[$key] : null;
    }

    /**
     * Convertit un élément en flottant.
     *
     * @param int|string $key La clé de l'élément.
     * @return float|null La valeur convertie en flottant, ou null si la clé n'existe pas.
     */
    public function castToFloat(int|string $key): float|null
    {
        return $this->hasKey($key) ? (float) $this->items[$key] : null;
    }

    /**
     * Convertit un élément en booléen.
     *
     * @param int|string $key La clé de l'élément.
     * @return bool La valeur convertie en booléen.
     */
    public function castToBool(int|string $key): bool
    {
        return $this->hasKey($key) ? (bool) $this->items[$key] : false;
    }

    /**
     * Applique une transformation à chaque élément de la collection.
     *
     * @param callable $callback La fonction de transformation.
     * @return self Une nouvelle collection avec les éléments transformés.
     */
    public function map(callable $callback): self
    {
        $mappedItems = array_map($callback, $this->items);
        return new self($mappedItems);
    }

    /**
     * Réduit la collection à une seule valeur.
     *
     * @param callable $callback La fonction de réduction.
     * @param mixed $initial La valeur initiale.
     * @return mixed La valeur résultante.
     */
    public function reduce(callable $callback, mixed $initial = null): mixed
    {
        return array_reduce($this->items, $callback, $initial);
    }

    /**
     * Grouper les éléments par une clé donnée.
     *
     * @param callable $callback La fonction de groupe.
     * @return array Un tableau de groupes.
     */
    public function groupBy(callable $callback): array
    {
        $grouped = [];
        foreach ($this->items as $item) {
            $key = $callback($item);
            $grouped[$key][] = $item;
        }
        return $grouped;
    }

    /**
     * Aplatir la collection en un seul niveau.
     *
     * @return self Une nouvelle collection aplatie.
     */
    public function flatten(): self
    {
        $flattened = array_merge(...$this->items);
        return new self($flattened);
    }

    /**
     * Trie les éléments de la collection par une clé spécifique.
     *
     * @param string $key La clé par laquelle trier.
     * @return self La collection triée.
     */
    public function sortBy(string $key): self
    {
        usort($this->items, fn($a, $b) => $a[$key] <=> $b[$key]);
        return new self($this->items);
    }
}