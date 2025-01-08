<?php
namespace Khalil\Utils;


  /**
     * Class StringUtils
     *
     * Fournit des méthodes utilitaires pour manipuler les chaînes de caractères en PHP.
     */
final class Str {

        /**
         * Convertit une chaîne en minuscules.
         *
         * @param string $str La chaîne à convertir.
         * @return string La chaîne convertie en minuscules.
         */
        public static function toLowerCase(string $str): string
        {
            return mb_strtolower($str, 'UTF-8');
        }
    
        /**
         * Convertit une chaîne en majuscules.
         *
         * @param string $str La chaîne à convertir.
         * @return string La chaîne convertie en majuscules.
         */
        public static function toUpperCase(string $str): string
        {
            return mb_strtoupper($str, 'UTF-8');
        }
    
        /**
         * Capitalise la première lettre de chaque mot dans une chaîne.
         *
         * @param string $str La chaîne à modifier.
         * @return string La chaîne avec la première lettre de chaque mot en majuscule.
         */
        public static function capitalizeWords(string $str): string
        {
            return mb_convert_case($str, MB_CASE_TITLE, 'UTF-8');
        }
    
        /**
         * Vérifie si une chaîne contient une autre chaîne (insensible à la casse).
         *
         * @param string $haystack La chaîne dans laquelle chercher.
         * @param string $needle La chaîne à rechercher.
         * @return bool Vrai si la chaîne contient la sous-chaîne, sinon faux.
         */
        public static function contains(string $haystack, string $needle): bool
        {
            return mb_stripos($haystack, $needle) !== false;
        }
    
        /**
         * Vérifie si une chaîne commence par une sous-chaîne donnée.
         *
         * @param string $haystack La chaîne à examiner.
         * @param string $needle La sous-chaîne à rechercher au début.
         * @return bool Vrai si la chaîne commence par la sous-chaîne, sinon faux.
         */
        public static function startsWith(string $haystack, string $needle): bool
        {
            return mb_substr($haystack, 0, mb_strlen($needle, 'UTF-8')) === $needle;
        }
    
        /**
         * Vérifie si une chaîne se termine par une sous-chaîne donnée.
         *
         * @param string $haystack La chaîne à examiner.
         * @param string $needle La sous-chaîne à rechercher à la fin.
         * @return bool Vrai si la chaîne se termine par la sous-chaîne, sinon faux.
         */
        public static function endsWith(string $haystack, string $needle): bool
        {
            return mb_substr($haystack, -mb_strlen($needle, 'UTF-8')) === $needle;
        }
    
        /**
         * Remplace toutes les occurrences d'une sous-chaîne dans une chaîne.
         *
         * @param string $haystack La chaîne dans laquelle effectuer le remplacement.
         * @param string $needle La sous-chaîne à rechercher.
         * @param string $replacement La chaîne qui remplacera chaque occurrence de la sous-chaîne.
         * @return string La chaîne après remplacement.
         */
        public static function replace(string $haystack, string $needle, string $replacement): string
        {
            return str_replace($needle, $replacement, $haystack);
        }
    
        /**
         * Supprime les espaces au début et à la fin d'une chaîne.
         *
         * @param string $str La chaîne à traiter.
         * @return string La chaîne sans les espaces en début et fin.
         */
        public static function trim(string $str): string
        {
            return trim($str);
        }
    
        /**
         * Divise une chaîne en un tableau de sous-chaînes.
         *
         * @param string $str La chaîne à diviser.
         * @param string $delimiter Le séparateur.
         * @return array Le tableau des sous-chaînes.
         */
        public static function split(string $str, string $delimiter): array
        {
            return explode($delimiter, $str);
        }
    
        /**
         * Retourne la longueur d'une chaîne.
         *
         * @param string $str La chaîne à analyser.
         * @return int La longueur de la chaîne.
         */
        public static function length(string $str): int
        {
            return mb_strlen($str, 'UTF-8');
        }
    
        /**
         * Vérifie si une chaîne est vide.
         *
         * @param string $str La chaîne à vérifier.
         * @return bool Vrai si la chaîne est vide, sinon faux.
         */
        public static function isEmpty(string $str): bool
        {
            return empty($str);
        }
    
        /**
         * Supprime les doublons de caractères dans une chaîne.
         *
         * @param string $str La chaîne à traiter.
         * @return string La chaîne sans doublons de caractères.
         */
        public static function removeDuplicates(string $str): string
        {
            return implode('', array_unique(mb_str_split($str)));
        }
    
        /**
         * Récupère la sous-chaîne à partir d'une position donnée.
         *
         * @param string $str La chaîne à couper.
         * @param int $start La position de départ.
         * @param int|null $length La longueur de la sous-chaîne (optionnelle).
         * @return string La sous-chaîne extraite.
         */
        public static function substring(string $str, int $start, int $length = null): string
        {
            return mb_substr($str, $start, $length, 'UTF-8');
        }
    
        /**
         * Remplace les espaces par des tirets dans une chaîne.
         *
         * @param string $str La chaîne à modifier.
         * @return string La chaîne avec les espaces remplacés par des tirets.
         */
        public static function replaceSpacesWithDashes(string $str): string
        {
            return self::replace($str, ' ', '-');
        }
    
        /**
         * Génère une chaîne aléatoire de longueur spécifiée.
         *
         * @param int $length La longueur de la chaîne à générer.
         * @return string La chaîne générée aléatoirement.
         */
        public static function generateRandomString(int $length): string
        {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = mb_strlen($characters, 'UTF-8');
            $randomString = '';
    
            // Utilisation de la fonction random_int() pour une génération de nombres aléatoires sécurisée
            for ($i = 0; $i < $length; $i++) {
                $randomIndex = random_int(0, $charactersLength - 1);
                $randomString .= mb_substr($characters, $randomIndex, 1, 'UTF-8');
            }
    
            return $randomString;
        }
    
        /**
         * Convertit une chaîne en un format de "slug".
         *
         * @param string $str La chaîne à convertir.
         * @return string La chaîne convertie en slug.
         */
        public static function slugify(string $str): string
        {
            // Convertir les caractères spéciaux et les espaces en tirets
            $str = self::toLowerCase($str);
            $str = preg_replace('/[^a-z0-9]+/i', '-', $str); // Remplacer les non-alphanumériques par des tirets
            $str = trim($str, '-'); // Enlever les tirets en début et fin de chaîne
            return $str;
        }
    
        /**
         * Tronque une chaîne à une longueur donnée et ajoute un suffixe si la chaîne est trop longue.
         *
         * @param string $str La chaîne à tronquer.
         * @param int $length La longueur maximale.
         * @param string $suffix Le suffixe à ajouter (par défaut '...').
         * @return string La chaîne tronquée.
         */
        public static function truncate(string $str, int $length, string $suffix = '...'): string
        {
            if (self::length($str) <= $length) {
                return $str;
            }
            return self::substring($str, 0, $length) . $suffix;
        }
    
        /**
         * Convertit une chaîne en "snake_case".
         *
         * @param string $str La chaîne à convertir.
         * @return string La chaîne convertie en snake_case.
         */
        public static function camelCaseToSnakeCase(string $str): string
        {
            return self::toLowerCase(preg_replace('/[A-Z]/', '_$0', lcfirst($str)));
        }
    }
