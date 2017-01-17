<?php

use PHPKitty\LazyModuleProcessor;
use PHPKitty\LazyModuleProcessorStore;
use PHPKitty\Module;

use PHPUnit\Framework\TestCase;

class LazyModuleProcessorStoreTest extends TestCase {

    function testPreservesKeys() {
        $module = new LazyModuleProcessor(new Module(), []);
        $store = new LazyModuleProcessorStore();
        $store->add('foo', $module);
        $this->assertEquals($module, $store->get('foo'));
    }

    function testThrowsOnInvalidKey() {
        $this->expectException(PHPKitty\Exception::class);
        $store = new LazyModuleProcessorStore();
        $store->get('not_exists');
    }
}