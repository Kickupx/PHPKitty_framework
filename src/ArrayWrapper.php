<?php
namespace PHPKitty;

class ArrayWrapper {
    private $array;

    public function __construct(array $array) {
        $this->array = $array;
    }

    public function __get($name) {
        if(!isset($this->array[$name]))
            return null;
        return $this->array[$name];
    }
}