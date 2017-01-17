<?php
namespace PHPKitty;

class FileTemplateLoader extends \Twig_Loader_Filesystem {
    private $code = '';

    public function __construct($dir) {
        parent::__construct($dir);
    }

    public function addModule($output_key) {
        $this->code .= '$context[\'' . $output_key . '\'] = PHPKitty\\DI::get(PHPKitty\\LazyModuleProcessorStore::class)->get(\'' . $output_key . "');\n";
    }

    public function getSourceContext($name) {
        $source = parent::getSourceContext($name);
        $code = $this->generateModuleProcessorCalls($source->getCode());
        return new \Twig_Source($code, $source->getName(), $source->getPath());
    }

    private function generateModuleProcessorCalls($code) {
        $prepend = "<?php\n " . $this->code . "?>\n";
        return $prepend . $code;
    }
}