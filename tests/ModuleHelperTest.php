<?php

use PHPKitty\ModuleHelper;
use PHPKitty\ModuleInstruction;

use PHPUnit\Framework\TestCase;

class ModuleHelperTests extends TestCase  {
    public function testCall() {
        $helper = new ModuleHelper();
        $module = $helper->module(1, 2, 3);

        $this->assertEquals(new ModuleInstruction('module', [1,2,3]), $module);
    }
}