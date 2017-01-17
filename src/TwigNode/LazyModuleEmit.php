<?php
namespace PHPKitty\TwigNode;

use PHPKitty\LazyModuleLoaderGenerator;

final class LazyModuleEmit extends \Twig_Node
{
    private $generator;

    public function __construct(LazyModuleLoaderGenerator $generator) {
        $this->generator = $generator;
    }

    public function compile(\Twig_Compiler $compiler)
    {
        $compiler
            ->addDebugInfo($this)
            ->write($this->generator->generate())
        ;
    }
}