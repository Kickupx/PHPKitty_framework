<?php
namespace PHPKitty;


class ModuleHelper {
    
    public function __call($name, array $args) {
        return new ModuleInstruction($name, $args);
    }
}