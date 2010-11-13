<?php
class baxe_Logger_JavascriptConsole extends baxe_Logger_Adapter {


    public static function getInstance(baxe_App_Abstract $app) {
        return new baxe_Logger_JavascriptConsole($app);
    }

    /**
     * (non-PHPdoc)
     * @see lib/library/baxe/Logger/baxe_Logger_Adapter#fatal($message)
     */
    public function fatal($message) {
        echo $this->render($message);
    }

    /**
     * (non-PHPdoc)
     * @see lib/library/baxe/Logger/baxe_Logger_Adapter#error($message)
     */
    public function error($message) {
        echo $this->render($message);
    }

    /**
     * (non-PHPdoc)
     * @see lib/library/baxe/Logger/baxe_Logger_Adapter#warn($message)
     */
    public function warn($message) {
        echo $this->render($message);
    }

    /**
     * (non-PHPdoc)
     * @see lib/library/baxe/Logger/baxe_Logger_Adapter#info($message)
     */
    public function info($message) {
        echo $this->render($message);
    }

    /**
     * (non-PHPdoc)
     * @see lib/library/baxe/Logger/baxe_Logger_Adapter#debug($message)
     */
    public function debug($message) {
        echo $this->render($message);
    }

    /**
     * (non-PHPdoc)
     * @see lib/library/baxe/Logger/baxe_Logger_Adapter#trace($message)
     */
    public function trace($message) {
        echo $this->render($message);
    }


    /**
     * Render a script tag that outputs into console.log
     *
     * @param $message
     * @return string
     */
    private function render($message) {
        return '<script type="text/javascript">console.log("'. addslashes($message) .'");</script>';
    }

}
