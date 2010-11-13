<?php
class baxe_Logger_Null extends baxe_Logger_Adapter {

    /**
     * @param baxe_App_Abstract $app
     * @return baxe_Logger_File
     */
    public static function getInstance(baxe_App_Abstract $app) {
        return new self($app);
    }

    /**
     * (non-PHPdoc)
     * @see lib/library/baxe/Logger/baxe_Logger_Adapter#fatal($message)
     */
    public function fatal($message) {}

    /**
     * (non-PHPdoc)
     * @see lib/library/baxe/Logger/baxe_Logger_Adapter#error($message)
     */
    public function error($message) {}

    /**
     * (non-PHPdoc)
     * @see lib/library/baxe/Logger/baxe_Logger_Adapter#warn($message)
     */
    public function warn($message) {}

    /**
     * (non-PHPdoc)
     * @see lib/library/baxe/Logger/baxe_Logger_Adapter#info($message)
     */
    public function info($message) {}

    /**
     * (non-PHPdoc)
     * @see lib/library/baxe/Logger/baxe_Logger_Adapter#debug($message)
     */
    public function debug($message) {}

    /**
     * (non-PHPdoc)
     * @see lib/library/baxe/Logger/baxe_Logger_Adapter#trace($message)
     */
    public function trace($message) {}

}
