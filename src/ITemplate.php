<?php
namespace PHPKitty;

interface ITemplate {
    function name();
    function makeTwig(UserPermissions $user_permissions);
}