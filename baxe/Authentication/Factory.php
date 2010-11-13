<?php
class baxe_Authentication_Factory {

    /**
     * @param baxe_App_Abstract $app
     * @return baxe_Authentication_Abstract
     */
    public static function getInstance(baxe_App_Abstract $app) {
        $class = $app->getConfig()->config['auth.adapter'];
        return new $class($app);
    }

}
