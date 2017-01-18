<?php
namespace PHPKitty;

use PHPKitty\RouteDispatcher;

class RouteBuilder {
    private $module_stack = [];
    private $route_dispatcher;

    public function __construct(RouteDispatcher $route_dispatcher) {
        $this->route_dispatcher = $route_dispatcher;
    }

    public function get($template, $url, $modules = []) {
        $this->route_dispatcher->get($url, $modules, $template);
    }

    public function post($template, $url, $modules = []) {
        $this->route_dispatcher->post($url, $modules, $template);
    }

    public function getDispatcher() {
        return $this->route_dispatcher;
    }
}