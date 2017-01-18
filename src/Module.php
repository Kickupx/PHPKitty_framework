<?php
namespace PHPKitty;

class Module implements IModule {
    public $lazy = true;

    public $globals;
    public $server;
    public $get;
    public $post;
    public $files;
    public $cookie;
    public $session;
    public $request;
    public $env;

    public $config;
    public $db;

    public function beforeProcessing() {
        $this->globals    = DI::get('$GLOBALS');
        $this->server     = DI::get('$_SERVER');
        $this->get        = DI::get('$_GET');
        $this->post       = DI::get('$_POST');
        $this->files      = DI::get('$_FILES');
        $this->cookie     = DI::get('$_COOKIE');
        $this->session    = DI::get('$_COOKIE');
        $this->request    = DI::get('$_REQUEST');
        $this->env        = DI::get('$_ENV');
        $this->config     = function($id) { 
            try {
                return DI::get($id);
             } catch(\Exception $e) {
                 return null;
             } 
        };
        $this->db = function() { return DI::get(DB); };
    }

    public function process(array $input) {
        return null;
    }

    public function install(array $input) {

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