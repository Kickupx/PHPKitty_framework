<?php

use PHPKitty\ModuleHelper;
use PHPKitty\Module;

use PHPUnit\Framework\TestCase;

class ModuleTests extends TestCase  {

    public function testProcessModules() {
        $mh = new ModuleHelper();
        $modules = ["module1" => new Module1()];
        $instructions = [
            "var" => $mh->module1(1,2,3)
        ];
        $vars = Module::processModules($instructions, $modules);

        $this->assertEquals([
            'var' => [1,2,3]
        ], $vars);
    }
}

class Module1 extends Module {
    public function process(array $input) {
        return $input;
    }
}