<?php
class baxe_Logger {

    private static $instance;

    const DEFAULT_LOGGER = 'default';

    private $loggers = array();

    public function __construct(baxe_Logger_Adapter $logger) {
        $this->attach(DEFAULT_LOGGER, $logger);
    }


    /**
     * Get the app logger instance
     *
     * @param baxe_App_Abstract $app
     * @return baxe_Logger_Adapter
     * @throws Exception
     */
    public static function getInstance(baxe_App_Abstract $app) {
        if (!self::$instance instanceof self) {
            $adapterClass = $app->getConfig()->config['log.adapter'];

            $callback = array($adapterClass, 'getInstance');
            $adapter = call_user_func($callback, $app);

            if (!$adapter instanceof baxe_Logger_Adapter) {
                throw new Exception("Unable to get logging adapter instance: ". $adapterClass);
            }

            self::$instance = $adapter;
        }

        return self::$instance;
    }


    public function attach($name, baxe_Logger_Adapter $logger) {
        $this->loggers[$name] = $logger;
    }


    public function detach($name) {
        unset($this->loggers[$name]);
    }


    public function fatal($message) {
        echo $message;
    }

    public function error($message) {
        echo $message;
    }

    public function warn($message) {
        echo $message;
    }

    public function info($message) {
        echo $message;
    }

    public function debug($message) {
        echo $message;
    }

    public function trace($message) {
        echo $message;
    }

}
