<?php
namespace PHPKitty;

class LazyModuleProcessorStore {
    private $lazy_modules = [];

    public function add($output_key, LazyModuleProcessor $module) {
        $lazy_modules[$output_key] = $module;
    }

    public function get($output_key) {
        if(!isset($this->lazy_modules[$output_key]))
            throw new Exception("Module which outputs in key $output is not defined");
        return $lazy_modules[$output_key];
    }
}