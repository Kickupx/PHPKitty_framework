<?php

use PHPKitty\RouteDispatcher;
use PHPKitty\UserPermissions;
use PHPKitty\Template\TextTemplate;
use PHPKitty\TwigNode\Permission as NodePermissions;

use FastRoute\Dispatcher as FastD;

use PHPUnit\Framework\TestCase;

class RouteDispatcherTest extends TestCase {

    public function testGetFound() {
        $d = $this->makeDispatcher('GET');
        $this->assertEquals($d->dispatch('GET', '/index')[0], FastD::FOUND);
    }

    public function testGetNotFound() {
        $d = $this->makeDispatcher('GET');
        $this->assertEquals($d->dispatch('GET', '/not_exists')[0], FastD::NOT_FOUND);
    }

    public function testPostFound() {
        $d = $this->makeDispatcher('POST');
        $this->assertEquals($d->dispatch('POST', '/index')[0], FastD::FOUND);
    }

    public function testPostNotFound() {
        $d = $this->makeDispatcher('POST');
        $this->assertEquals($d->dispatch('POST', '/not_exists')[0], FastD::NOT_FOUND);
    }

    private function makeDispatcher($method) {
        NodePermissions::reset();
        $permissions = new UserPermissions(['guest', 'user']);
        $permissions->setCurrent('guest');

        $dispatcher = new RouteDispatcher($permissions, []);
        call_user_func([$dispatcher, $method], '/index', [], new TextTemplate(''));
        return $dispatcher;
    }
}