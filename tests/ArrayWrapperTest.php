<?php

use PHPKitty\ArrayWrapper;

use PHPUnit\Framework\TestCase;

class ArrayWrapperTest extends TestCase {

    function testItemNotExists() {
        $w = new ArrayWrapper(['foo' => 42, 'bar' => 'zebra']);
        $this->assertEquals($w->not_exists, null);
    }

    function testItemExists() {
        $w = new ArrayWrapper(['foo' => 42]);
        $this->assertEquals($w->foo, 42);
    }
}