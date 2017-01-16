<?php
namespace PHPKitty;

final class UserPermissions {
    private $permission_names = [];
    private static $permission = 0;

    public function __construct(array $names) {
        $this->permission_names = $names;
    }

    public static function getCurrent() {
        return self::$permission;
    }

    public function setCurrent($name) {
        $v = $this->valueOf($name);
        if($v === FALSE)
            throw new Exception("There are now permission named $name");
        self::$permission = $v;
    }

    public function all_names() {
        return $this->permission_names;
    }

    public function valueOf($name) {
        return array_search($name, $this->permission_names);
    }
}