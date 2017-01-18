<?php
namespace PHPKitty;

use PHPKitty\IModule;

class ModuleListBuilder {
    private $modules = [];

    public function add($name, IModule $module) {
        $this->modules[$name] = $module;
    }

    public function getAll() {
        return $this->modules;
    }
}