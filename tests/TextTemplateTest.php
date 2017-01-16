<?php

use PHPKitty\Template\TextTemplate;
use PHPKitty\UserPermissions;
use PHPUnit\Framework\TestCase;

class TextTemplateTest extends TestCase  {
    
    public function testTextExists() {
        $text = 'foo bar zebra';
        $template = new TextTemplate($text);
        $twig = $template->makeTwig(new UserPermissions([]));
        $this->assertTrue($twig->getLoader()->exists($template->name()));
    }
}