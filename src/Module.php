<?php
namespace PHPKitty;

class Module implements IModule {
    public function process(array $input) {
        return null;
    }

    public static function processModules(array $mod_instructions, array $mods) {
        $variables = [];
    
        foreach($mod_instructions as $name => $instructions) {
            if(!isset($mods[$name]))
                throw new Exception("There are no module named $name");
            
            $module = $mods[$name];
            if(!($module instanceof Module))
                throw new Exception("Module with name $module is not an instance of class Module");
            
            $input = [];
            if(isset($instructions["input"])) {
                $input = $instructions["input"];
                if(!is_array($input))
                    throw new Exception("Input of module $name has to be an array");
            }
            
            $output = $module->process($input);
            
            if(!is_null($output)) {
                if(!isset($instructions["output"]) || !is_string($instructions["output"]))
                    throw new Exception("output key of module with name $name is not defined even though it spites out output");
                
                $output_key = $instructions["output"];
                if(isset($variables[$output_key]))
                    throw new Exception("Output variable \"$output\" is defined several times");
                $variables[$output_key] = $output;
            }
        }
        
        return $variables;
    }
}