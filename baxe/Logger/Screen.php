<?php
class baxe_Logger_Screen extends baxe_Logger_Adapter {


    public static function getInstance(baxe_App_Abstract $app) {
        return new baxe_Logger_Screen($app);
    }

    /**
     * (non-PHPdoc)
     * @see lib/library/baxe/Logger/baxe_Logger_Adapter#fatal($message)
     */
    public function fatal($message) {
        echo $message;
    }

    /**
     * (non-PHPdoc)
     * @see lib/library/baxe/Logger/baxe_Logger_Adapter#error($message)
     */
    public function error($message) {
        echo $message;
    }

    /**
     * (non-PHPdoc)
     * @see lib/library/baxe/Logger/baxe_Logger_Adapter#warn($message)
     */
    public function warn($message) {
        echo $message;
    }

    /**
     * (non-PHPdoc)
     * @see lib/library/baxe/Logger/baxe_Logger_Adapter#info($message)
     */
    public function info($message) {
        echo $message;
    }

    /**
     * (non-PHPdoc)
     * @see lib/library/baxe/Logger/baxe_Logger_Adapter#debug($message)
     */
    public function debug($message) {
        echo $message;
    }

    /**
     * (non-PHPdoc)
     * @see lib/library/baxe/Logger/baxe_Logger_Adapter#trace($message)
     */
    public function trace($message) {
        echo $message;
    }

}
