<?php
namespace PHPKitty\TwigTokenParser;

use \PHPKitty\LazyModuleLoaderGenerator;

class LazyModuleEmit extends \Twig_TokenParser {
    private $template;

    public function __construct(LazyModuleLoaderGenerator $template) {
        $this->template = $template;
    }

    public function parse(\Twig_Token $token)
    {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();
        $stream->expect(\Twig_Token::BLOCK_END_TYPE);

        return new \PHPKitty\TwigNode\LazyModuleEmit($this->template);
    }

    public function getTag() {
        return 'phpkitty_lazy_module_emit'
    }
}