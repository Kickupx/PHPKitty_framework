<?php
namespace PHPKitty;

class ArrayWrapper {
    private $array;

    public function __construct(array $array) {
        $this->array = $array;
    }

    public function __get($name) {
        if(!array_key_exists($name, $this->array))
            return null;
        return $this->array[$name];
    }
}