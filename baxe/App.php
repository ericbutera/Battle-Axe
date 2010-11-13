<?php
/**
 * this is a generic wrapper to be called in your front end script so that all
 * internal classes can reference baxe_App::getInstance to get the current app
 * context.  this is for being lazy as real dependency injection is very verbose.
 *
 * you can still do pure di by calling the ctors and passing around the app
 * instance, but this is a way to keep your sanity.
 */
class baxe_App {

    private static $instance;

    /**
     * @return baxe_App_Abstract
     */
    public static function getInstance() {
        return self::$instance;
    }

    /**
     * @param baxe_App_Abstract $app
     * @return baxe_App_Abstract fluent interface
     */
    public static function setInstance(baxe_App_Abstract $app) {
        self::$instance = $app;
        return self::$instance;
    }

}
