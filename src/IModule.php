<?php
namespace PHPKitty;

interface IModule {
    public function process(array $input);
    public function install(array $input);
}