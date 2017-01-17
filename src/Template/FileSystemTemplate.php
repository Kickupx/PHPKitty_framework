<?php
namespace PHPKitty\Template;

use PHPKitty\ITemplate;
use PHPKitty\UserPermissions;

use Pimple\Container as DI;

class FileSystemTemplate implements ITemplate {
    private $dir;
    private $name_v;

    public function __construct($dir, $name) {
        $this->dir = $dir;
        $this->name_v = $name;
    }

    public function name() {
        return $this->name_v;
    }

    public function makeTwig(UserPermissions $user_permissions, $env_factory = null) {
        $twig_loader = new \Twig_Loader_Filesystem($this->dir);
        $twig = $env_factory ? $env_factory($twig_loader) : new \Twig_Environment($twig_loader);

        $twig->addTokenParser(new \PHPKitty\TwigTokenParser\Permission($user_permissions));
        return $twig;
    }
}