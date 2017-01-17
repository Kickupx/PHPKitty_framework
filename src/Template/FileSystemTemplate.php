<?php
namespace PHPKitty\Template;

use PHPKitty\ITemplate;
use PHPKitty\UserPermissions;

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

    public function makeTwig(UserPermissions $user_permissions) {
        $twig_loader = new \Twig_Loader_Filesystem($this->dir);
        $twig = new \Twig_Environment($twig_loader);

        $twig->addTokenParser(new \PHPKitty\TwigTokenParser\Permission($user_permissions));
        return $twig;
    }
}