<?php
/**
 * Logs messages into whatever php fopen supports
 *
 */
class baxe_Logger_File extends baxe_Logger_Adapter {

    /**
     * @var resource
     */
    private $fp;

    public function __destruct() {
        if (is_resource($this->fp)) {
            fclose($this->fp);
        }
    }

    /**
     * @param baxe_App_Abstract $app
     * @return baxe_Logger_File
     */
    public static function getInstance(baxe_App_Abstract $app) {
        return new self($app);
    }

    /**
     * Lazy load the log file only if it is needed
     *
     * @return resource
     * @throws Exception
     */
    private function getHandle() {
        if (!is_resource($this->fp)) {
            $config = $this->app->getConfig();

            if (!isset($config->config['log.file'])) {
                throw new Exception("log.file is not set.");
            }

            $this->fp = fopen($config->config['log.file'], 'a');

            $this->write("Starting logging sesssion", 'info');
        }
        return $this->fp;
    }

    /**
     * Use this to put the message in the log file
     *
     * @param string $message
     * @return void
     * @throws Exception
     */
    private function write($message, $level) {
        $m = "[". date('D M j G:i:s T Y') ."][{$level}]";
        if (isset($_SERVER['REMOTE_ADDR'])) {
            $m .= "[". htmlspecialchars($_SERVER['REMOTE_ADDR']) ."]";
        }
        $m .= " {$message}\n";

        if (false === fwrite($this->getHandle(), $m)) {
            throw new Exception("Unable to write to log file.");
        }
    }

    /**
     * (non-PHPdoc)
     * @see lib/library/baxe/Logger/baxe_Logger_Adapter#fatal($message)
     */
    public function fatal($message) {
        $this->write($message, 'fatal');
    }

    /**
     * (non-PHPdoc)
     * @see lib/library/baxe/Logger/baxe_Logger_Adapter#error($message)
     */
    public function error($message) {
        $this->write($message, 'error');
    }

    /**
     * (non-PHPdoc)
     * @see lib/library/baxe/Logger/baxe_Logger_Adapter#warn($message)
     */
    public function warn($message) {
        $this->write($message, 'warn');
    }

    /**
     * (non-PHPdoc)
     * @see lib/library/baxe/Logger/baxe_Logger_Adapter#info($message)
     */
    public function info($message) {
        $this->write($message, 'info');
    }

    /**
     * (non-PHPdoc)
     * @see lib/library/baxe/Logger/baxe_Logger_Adapter#debug($message)
     */
    public function debug($message) {
        $this->write($message, 'debug');
    }

    /**
     * (non-PHPdoc)
     * @see lib/library/baxe/Logger/baxe_Logger_Adapter#trace($message)
     */
    public function trace($message) {
        $this->write($message, 'trace');
    }

}
