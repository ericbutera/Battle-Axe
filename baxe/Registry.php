<?php
class baxe_Registry {

    private static $store = array();

    public static function get($key) {
        if (!isset(self::$store[$key])) {
            throw new Exception("Key {$key} is not in the registry.");
        }
        return self::$store[$key];
    }

    public static function set($key, $value) {
        self::$store[$key] = $value;
    }

    public static function has($key) {
        return isset(self::$store[$key]);
    }

}
