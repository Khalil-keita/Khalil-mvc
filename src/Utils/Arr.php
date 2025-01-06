<?php
namespace Khalil\Utils;

final class Arr {

    public static function contains(array $array, $needle, bool $strict = false): bool {
        return in_array($needle, $array, $strict);
    }

    public static function mergeUnique(array ... $array): array {
        return array_values(array_unique(array_merge( $array)));
    }

    public static function sortByKey(array &$array, bool $descending = false): void{
        $descending ? krsort($array) : ksort($array);
    }

    public static function sortByValue(array $array, bool $descending = false): void{
        $descending ? arsort($array) : asort($array);
    }

    public static function filter(array $array, callable $callback): array {
        return array_filter($array, $callback);
    }

    public static function flatten(array $array): array{
        $result = [];
        foreach( $array as $value ){
            if(is_array($value)){
                $result = array_merge($result, self::flatten($value));
            }else{
                $result[] = $value;
            }
        }
        return $result;
    }

    public static function merge(array &$array, array ...$arrays): array{
       $result = static::flatten($arrays);
       return array_merge( $array, $result );
    }
}