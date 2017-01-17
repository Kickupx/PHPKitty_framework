<?php
namespace PHPKitty;

class RouteDispatcher {
    private $router;
    private $user_permissions;
    private $module_list;
    private $twig_factory;

    public function __construct(UserPermissions $user_permissions, array $module_list, $twig_factory = null) {
        $this->user_permissions = $user_permissions;
        $this->module_list = $module_list;
        $this->twig_factory = $twig_factory;
        $this->router = new \FastRoute\RouteCollector(
            new \FastRoute\RouteParser\Std(), new \FastRoute\DataGenerator\GroupCountBased() 
        );
    }

    public function render($modules_call_decl, ITemplate $template, UserPermissions $user_permissions) {
        $variables = Module::processModules($modules_call_decl, $this->module_list);
        $twig = $template->makeTwig($user_permissions, $twig_factory);
        return $twig->render($template->name(), $variables);
    }

    public function get($route, $modules, ITemplate $template) {
        $this->add('GET', $route, $modules, $template);
    }

    public function post($route, $modules, ITemplate $template) {
        $this->add('POST', $route, $modules, $template);
    }

    public function dispatch($method, $url) {
        $dispatcher = new \FastRoute\Dispatcher\GroupCountBased($this->router->getData());
        return $dispatcher->dispatch($method, $url);
    }

    private function add($method, $route, $modules, ITemplate $template) {
        $this->router->addRoute($method, $route, function() use($modules, $template) {
            echo $this->render($modules, $template, $this->user_permissions);
        });
    }
}