<?php
namespace PHPKitty;

class WantedIndicesStore {
    public function __get($name) {
        return new WantedIndiceValue($name);
    }

    public function replaceWantedIndices(array $values, array &$target) {
        foreach($target as $k => &$v) {
            if(is_array($v))
                $this->replaceWantedIndices($values, $v);
            else {
                if($v instanceof WantedIndiceValue) {
                    $indice_key = $v->key();
                    foreach($values as $value_array) {
                        if(array_key_exists($indice_key, $value_array)) {
                            $target[$k] = $value_array[$indice_key];
                            continue 2;
                        }
                    }
                    $target[$k] = null;
                }
            }
        }
    }
}