<?php
namespace Khalil\Utils;

/**
 * Class Arr
 *
 * Fournit des méthodes utilitaires pour manipuler les tableaux en PHP.
 */
class Arr
{
    /**
     * Filtre un tableau en fonction d'un callback.
     *
     * @param array $array Le tableau à filtrer.
     * @param callable $callback La fonction de filtrage.
     * @return array Le tableau filtré.
     */
    public static function filter(array $array, callable $callback): array
    {
        return array_filter($array, $callback, ARRAY_FILTER_USE_BOTH);
    }

    /**
     * Applique une transformation à chaque élément du tableau.
     *
     * @param array $array Le tableau à transformer.
     * @param callable $callback La fonction de transformation.
     * @return array Le tableau transformé.
     */
    public static function map(array $array, callable $callback): array
    {
        return array_map($callback, $array);
    }

    /**
     * Vérifie si une valeur existe dans un tableau.
     *
     * @param array $array Le tableau à examiner.
     * @param mixed $value La valeur à rechercher.
     * @param bool $strict Comparaison stricte si vrai.
     * @return bool Vrai si la valeur existe, sinon faux.
     */
    public static function hasValue(array $array, mixed $value, bool $strict = false): bool
    {
        return in_array($value, $array, $strict);
    }

    /**
     * Vérifie si une clé existe dans un tableau.
     *
     * @param array $array Le tableau à examiner.
     * @param int|string $key La clé à rechercher.
     * @return bool Vrai si la clé existe, sinon faux.
     */
    public static function hasKey(array $array, int|string $key): bool
    {
        return array_key_exists($key, $array);
    }

    /**
     * Trie un tableau par valeur.
     *
     * @param array $array Le tableau à trier.
     * @param bool $ascending Tri croissant si vrai.
     * @return array Le tableau trié par valeur.
     */
    public static function sortByValue(array $array, bool $ascending = true): array
    {
        $sorted = $array;
        $ascending ? asort($sorted) : arsort($sorted);
        return $sorted;
    }

    /**
     * Trie un tableau par clé.
     *
     * @param array $array Le tableau à trier.
     * @param bool $ascending Tri croissant si vrai.
     * @return array Le tableau trié par clé.
     */
    public static function sortByKey(array $array, bool $ascending = true): array
    {
        $sorted = $array;
        $ascending ? ksort($sorted) : krsort($sorted);
        return $sorted;
    }

    /**
     * Recherche un élément dans le tableau et retourne sa clé.
     *
     * @param array $array Le tableau à examiner.
     * @param mixed $value La valeur à rechercher.
     * @param bool $strict Comparaison stricte si vrai.
     * @return int|string|null La clé de l'élément ou null si non trouvé.
     */
    public static function search(array $array, mixed $value, bool $strict = false): int|string|null
    {
        return array_search($value, $array, $strict);
    }

    /**
     * Définit ou modifie la valeur d'une clé dans un tableau, ou ajoute un élément à la fin si la clé n'existe pas.
     *
     * @param array &$array Le tableau à modifier.
     * @param int|string $key La clé à modifier ou ajouter.
     * @param mixed $value La valeur à définir ou ajouter.
     * @return void
     */
    public static function set(array &$array, int|string $key, mixed $value): void
    {
        $array[$key] = $value;
    }

    /**
     * Supprime un élément à une clé spécifique dans un tableau.
     *
     * @param array &$array Le tableau à modifier.
     * @param int|string $key La clé de l'élément à supprimer.
     * @return bool Vrai si l'élément a été supprimé, sinon faux.
     */
    public static function remove(array &$array, int|string $key): bool
    {
        if (self::hasKey($array, $key)) {
            unset($array[$key]);
            return true;
        }
        return false;
    }

    /**
     * Fusionne plusieurs tableaux en un seul.
     *
     * @param array ...$arrays Les tableaux à fusionner.
     * @return array Le tableau fusionné.
     */
    public static function merge(array ...$arrays): array
    {
        return array_merge(...$arrays);
    }

    /**
     * Vérifie si un tableau est vide.
     *
     * @param array $array Le tableau à vérifier.
     * @return bool Vrai si le tableau est vide, sinon faux.
     */
    public static function isEmpty(array $array): bool
    {
        return count($array) === 0;
    }

    /**
     * Divise un tableau en sous-tableaux de taille fixe.
     *
     * @param array $array Le tableau à diviser.
     * @param int $size La taille des sous-tableaux.
     * @return array Les sous-tableaux.
     */
    public static function chunk(array $array, int $size): array
    {
        return array_chunk($array, $size);
    }

    /**
     * Supprime les doublons dans un tableau.
     *
     * @param array $array Le tableau d'entrée.
     * @return array Le tableau sans doublons.
     */
    public static function unique(array $array): array
    {
        return array_unique($array);
    }

    /**
     * Récupère un sous-ensemble du tableau à partir de la clé spécifiée.
     *
     * @param array $array Le tableau d'origine.
     * @param int|string $key La clé à partir de laquelle extraire un élément ou un sous-tableau.
     * @return mixed L'élément ou le sous-tableau, ou null si la clé n'existe pas.
     */
    public static function get(array $array, int|string $key): mixed
    {
        return self::hasKey($array, $key) ? $array[$key] : null;
    }

    /**
     * Récupère les valeurs communes entre plusieurs tableaux.
     *
     * @param array $array1 Le premier tableau.
     * @param array $array2 Le second tableau.
     * @return array Les éléments communs.
     */
    public static function intersect(array $array1, array $array2): array
    {
        return array_intersect($array1, $array2);
    }

    /**
     * Récupère les valeurs uniques parmi plusieurs tableaux.
     *
     * @param array ...$arrays Les tableaux à traiter.
     * @return array Les valeurs uniques combinées.
     */
    public static function union(array ...$arrays): array
    {
        return array_merge(...$arrays);
    }

    /**
     * Remplace les valeurs d'un tableau par une valeur spécifique selon une clé donnée.
     *
     * @param array &$array Le tableau à modifier.
     * @param int|string $key La clé des éléments à remplacer.
     * @param mixed $value La valeur à insérer.
     * @return void
     */
    public static function replaceByKey(array &$array, int|string $key, mixed $value): void
    {
        if (self::hasKey($array, $key)) {
            $array[$key] = $value;
        }
    }

    /**
     * Récupère la clé maximale d'un tableau.
     *
     * @param array $array Le tableau à examiner.
     * @return int|string|null La clé maximale ou null si le tableau est vide.
     */
    public static function maxKey(array $array): int|string|null
    {
        return empty($array) ? null : max(array_keys($array));
    }

    /**
     * Récupère la clé minimale d'un tableau.
     *
     * @param array $array Le tableau à examiner.
     * @return int|string|null La clé minimale ou null si le tableau est vide.
     */
    public static function minKey(array $array): int|string|null
    {
        return empty($array) ? null : min(array_keys($array));
    }

    /**
     * Transforme un tableau multidimensionnel en un tableau plat (une seule dimension).
     *
     * @param array $array Le tableau à aplatir.
     * @return array Le tableau aplati.
     */
    public static function flatten(array $array): array
    {
        $flattened = [];
        foreach ($array as $value) {
            if (is_array($value)) {
                $flattened = array_merge($flattened, self::flatten($value));
            } else {
                $flattened[] = $value;
            }
        }
        return $flattened;
    }

    /**
     * Vérifie si un tableau contient une sous-structure d'un tableau donné.
     *
     * @param array $array Le tableau principal.
     * @param array $subArray Le sous-tableau à rechercher.
     * @return bool Vrai si le sous-tableau est trouvé, sinon faux.
     */
    public static function containsSubarray(array $array, array $subArray): bool
    {
        return count(array_intersect_assoc($array, $subArray)) === count($subArray);
    }

    /**
     * Applique une fonction sur chaque élément d'un tableau en parallèle avec son index.
     *
     * @param array $array Le tableau à traiter.
     * @param callable $callback La fonction à appliquer.
     * @return array Le tableau après traitement.
     */
    public static function each(array $array, callable $callback): array
    {
        foreach ($array as $key => $value) {
            $callback($value, $key);
        }
        return $array;
    }

    /**
     * Convertit un tableau en JSON.
     *
     * @param array $array Le tableau à convertir.
     * @return string La chaîne JSON générée.
     */
    public static function toJson(array $array): string
    {
        return json_encode($array, JSON_THROW_ON_ERROR);
    }

    /**
     * Convertit un tableau en objet (stdClass).
     *
     * @param array $array Le tableau à convertir.
     * @return object L'objet résultant.
     */
    public static function toObject(array $array): object
    {
        return (object) $array;
    }

    /**
     * Convertit un tableau en chaîne de caractères.
     *
     * @param array $array Le tableau à convertir.
     * @return string La chaîne résultante.
     */
    public static function toString(array $array): string
    {
        return implode(", ", $array);
    }
}