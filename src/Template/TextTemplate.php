<?php
namespace PHPKitty\Template;

use PHPKitty\ITemplate;
use PHPKitty\UserPermissions;

class TextTemplate implements ITemplate {
    private $text;

    public function __construct($text) {
        $this->text = $text;
    }
    
    public function name() {
        return 'template';
    }

    public function makeTwig(UserPermissions $user_permissions) {
        $twig_loader = new \Twig_Loader_Array(['template' => $this->text]);
        $twig = new \Twig_Environment($twig_loader);

        $twig->addTokenParser(new \PHPKitty\TwigTokenParser\Permission($user_permissions));
        return $twig;
    }
}