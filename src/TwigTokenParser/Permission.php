<?php
namespace PHPKitty\TwigTokenParser;

use PHPKitty\TwigNode as Node;
use PHPKitty as PK;

final class Permission extends \Twig_TokenParser
{
    private $permissions;

    public function __construct(PK\UserPermissions $permissions) {
        $this->permissions = $permissions;
    }

    public function parse(\Twig_Token $token)
    {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();
        $name = $stream->expect(\Twig_Token::NAME_TYPE)->getValue();
        $stream->expect(\Twig_Token::BLOCK_END_TYPE);

        $permission_value = $this->permissions->valueOf($name);
        if($permission_value === FALSE)
            throw new \Twig_Syntax_Error("There are no permission named $name");

        $block = new \Twig_Node_Block($name, new \Twig_Node(array()), $lineno);
        $this->parser->setBlock($name, $block, $lineno);
        $this->parser->pushLocalScope();

        $body = $this->parser->subparse(array($this, 'decideBlockEnd'), true);
        $block->setNode('body', $body);
        $stream->expect(\Twig_Token::BLOCK_END_TYPE);

        $this->parser->popBlockStack();
        $this->parser->popLocalScope();
        
        return new Node\Permission($permission_value, $body, $lineno, $this->getTag());
    }

    public function decideBlockEnd(\Twig_Token $token)
    {
        return $token->test('endpermission');
    }

    public function getTag()
    {
        return 'permission';
    }
}