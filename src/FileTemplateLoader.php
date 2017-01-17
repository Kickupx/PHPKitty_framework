<?php
namespace PHPKitty;

class FileTemplateLoader extends \Twig_Loader_Filesystem {
    public function getSourceContext($name) {
        $source = parent::getSourceContext($name);
        $code = '{% botkitty_lazy_module_emit %}' . $source->getCode();
        return new \Twig_Source($code, $source->getName(), $source->getPath()); 
    }
}