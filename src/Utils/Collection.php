<?php
namespace Khalil\Utils; 

final class Collection extends \ArrayObject implements \ArrayAccess , \Countable
{

        public function __construct(private array $items = []){}

        public function get(string $key, mixed $default = null): mixed{
            return $this->items[$key] ?? $default;
        }

        public function set(string $key, mixed $value) : void{
            $this->items[$key] = $value;
        }

        public function remove(string $key): void{
            unset($this->items[$key]);
        }

        public function has(string $key) : bool{
            return isset($this->items[$key]);
        }

        public function getInt(string $key) : int{
            return (int) $this->get($key);
        }

        public function getFloat(string $key) :float {
            return (float) $this->get($key);
        }

        public function merge(array $items) : array {
            return Arr::merge($this->items, $items);
        }

        public function offsetExists($offset): bool{
            return array_key_exists($offset, $this->items);
        }

        public function offsetGet($offset): mixed{
            return $this->items[$offset];
        }

        public function offsetSet($offset, $value): void{
            $this->items[$offset] = $value;
        }

        public function offsetUnset($offset): void{
            unset($this->items[$offset]);
        }

        public function count(): int{
            return count($this->items);
        }

        public function getIterator(): \ArrayIterator{
            return new \ArrayIterator($this->items);
        }

}