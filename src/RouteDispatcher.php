<?php
namespace PHPKitty;

class RouteDispatcher {
    private $router;
    private $module_list;

    public function __construct(array $module_list) {
        $this->module_list = $module_list;
        $this->router = new \FastRoute\RouteCollector(
            new \FastRoute\RouteParser\Std(), new \FastRoute\DataGenerator\GroupCountBased() 
        );
    }

    public function get($route, $modules, $template_name) {
        $this->add('GET', $route, $modules, $template_name);
    }

    public function post($route, $modules, $template_name) {
        $this->add('POST', $route, $modules, $template_name);
    }

    public function dispatch($method, $url) {
        $dispatcher = new \FastRoute\Dispatcher\GroupCountBased($this->router->getData());
        return $dispatcher->dispatch($method, $url);
    }

    private function add($method, $route, $modules, $template_name) {
        $this->router->addRoute($method, $route, function() use($modules, $template_name) {
            return new DispatchResult($template_name, $modules);
        });
    }
}