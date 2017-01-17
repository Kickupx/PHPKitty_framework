<?php

use PHPKitty\RouteDispatcher;
use PHPKitty\UserPermissions;
use PHPKitty\Template\TextTemplate;
use PHPKitty\DI;
use PHPKitty\TwigNode\Permission as NodePermissions;

use DI\ContainerBuilder;
use DI\Container;

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

    public function testRender() {
        self::setupDI();
        $dispatcher = $this->makeDispatcher('GET');
        $dispatch = $dispatcher->dispatch('GET', '/index');
        $this->assertEquals($dispatch[0], FastRoute\Dispatcher::FOUND);
        
        $dispatch_result = $dispatch[1]();
        $twig = DI::get(Twig_Environment::class);
        $text = $twig->render($dispatch_result->templateName(), []);
        $this->assertEquals('content', $text);
    }

    private function setupDI() {
        $c = new ContainerBuilder();
        $c->addDefinitions([
            Twig_LoaderInterface::class => function(Container $c) { 
                return new Twig_Loader_Array(['/index' => 'content']);
            },
            Twig_Environment::class => function(Container $c) {
                return new Twig_Environment($c->get(Twig_LoaderInterface::class));
            }
        ]);
        DI::setContainer($c->build());
    }

    private function makeDispatcher($method) {
        $dispatcher = new RouteDispatcher([]);
        call_user_func([$dispatcher, $method], '/index', [], '/index');
        return $dispatcher;
    }
}