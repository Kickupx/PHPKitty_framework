<?php
namespace PHPKitty;

class Module implements IModule {
    public function process(array $input) {
        return null;
    }

    public static function processModules(array $mod_instructions, array $mods) {
        $result = [];
    
        foreach($mod_instructions as $variable => $instruction) {
            if(!$instruction instanceof ModuleInstruction)
                throw new Exception("A module instruction is not an instance of ModuleInstruction");

            $name = $instruction->name();
            if(!isset($mods[$name]))
                throw new Exception("There are no module named $name");
            
            $module = $mods[$name];
            if(!($module instanceof Module))
                throw new Exception("Module with name $module is not an instance of class Module");
            
            $input = $instruction->input();
            $output = $module->process($input);
            
            if(!is_null($output)) {
                if(!is_string($variable))
                    throw new Exception("output key of module with name $name is not defined even though it spites out output");
                
                if(array_key_exists($variable, $result))
                    throw new Exception("Output variable \"$output\" is defined several times");
                $result[$variable] = $output;
            }
        }
        
        return $result;
    }
}