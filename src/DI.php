<?php
namespace PHPKitty;

use \DI\Container;

class DI {
    private static $di;

    public static function get($id) {
        return self::$di->get($id);
    }

    public static function setContainer(Container $container) {
        self::$di = $container;
    }
}