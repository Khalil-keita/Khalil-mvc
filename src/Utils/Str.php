<?php
namespace Khalil\Utils;

final class Str {

    public static function contains(string $haystack, string $needle): bool{
        return strpos($haystack, $needle) !== false;
    }

    public static function endsWith(string $haystack, string $needle): bool{
        return substr($haystack, -strlen($needle)) === $needle;
    }

}