<?php
namespace PHPKitty;

class LazyModuleLoaderGenerator {
    private $code = '';

    public function addModule($output_key) {
        $this->code .= '$context[\'' . $output_key . '\'] = PHPKitty\\DI::get(PHPKitty\\LazyModuleProcessorStore::class)->get(\'' . $output_key . "');\n";
    }

    public function generate() {
        $prepend = "<?php\n " . $this->code . "?>\n";
        return $prepend . $code;
    }
}