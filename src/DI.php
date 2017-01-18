<?php
namespace PHPKitty;

use \DI\ContainerBuilder;
use \DI\Container;


class DI {
    private static $di;

    public static function get($id) {
        return self::$di->get($id);
    }

    public static function setContainer(Container $container) {
        self::$di = $container;
    }

    public static function setupPHPKitty() {
        $di_builder = new ContainerBuilder();
        $di_builder->addDefinitions(__DIR__ . '/env.php');

        $aw = function(array $arr) {
            return function(Container $c) use($arr) { new ArrayWrapper($arr); };
        };
        $di_builder->addDefinitions([
            '$GLOBALS' => $aw($GLOBALS),
            '$_SERVER' => $aw($_SERVER),
            '$_GET' => $aw($_GET),
            '$_POST' => $aw($_POST),
            '$_FILES' => $aw($_FILES),
            '$_COOKIE' => $aw($_COOKIE),
            '$_SESSION' => function(Container $c) { return new SessionArrayWrapper(); },
            '$_REQUEST' => $aw($_REQUEST),
            '$_ENV' => $aw($_ENV),

            \Twig_LoaderInterface::class => function(Container $c) {
                return $c->get(\PHPKitty\FileTemplateLoader::class);
            },
            FileTemplateLoader::class => function(Container $c) {
                return new FileTemplateLoader(__DIR__ . '/app/templates');
            },
            \Twig_Environment::class => function(Container $c) {
                $permissions = $c->get(UserPermissions::class);
                $config = $c->get('app.debug') ? [] : [
                    'cache' => __DIR__ . '/cache/twig'
                ];

                $twig = new \Twig_Environment($c->get(Twig_LoaderInterface::class), $config);
                $twig->addTokenParser(new TwigTokenParser\Permission($permissions));
                $twig->addTokenParser(new TwigTokenParser\LazyModuleEmit($c->get(LazyModuleLoaderGenerator::class)));
                return $twig;
            },
            UserPermissions::class => function(Container $c) use($permissions) {
                return new UserPermissions($permissions);
            }
        ]);
        DI::setContainer($di_builder->build());
    }
}