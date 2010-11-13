<?php
/**
 * Keeping all logger adapters in order. :)
 *
 * @author eric
 * @package battleaxe
 */
abstract class baxe_Logger_Adapter {

    /**
     * @var baxe_App_Abstract
     */
    protected $app;

    /**
     * Get an instance of the logger.  This is necessary for being lazy and
     * using baxe_App_Abstract::getLogger() to work.
     *
     * @param baxe_App_Abstract $app
     * @return baxe_Logger_Abstract
     */
    // abstract public static function getInstance(baxe_App_Abstract $app);

    public function __construct(baxe_App_Abstract $app) {
        $this->app = $app;
    }


    /**
     * Severe errors that cause premature termination. Expect these to be
     * immediately visible on a status console.
     *
     * @param string $message
     * @return void
     */
    abstract public function fatal($message);

    /**
     * Other runtime errors or unexpected conditions. Expect these to be
     * immediately visible on a status console.
     *
     * @param string $message
     * @return void
     */
    abstract public function error($message);

    /**
     * Use of deprecated APIs, poor use of API, 'almost' errors, other runtime
     * situations that are undesirable or unexpected, but not necessarily
     * "wrong". Expect these to be immediately visible on a status console.
     *
     * @param string $message
     * @return void
     */
    abstract public function warn($message);

    /**
     * Interesting runtime events (startup/shutdown). Expect these to be
     * immediately visible on a console, so be conservative and keep to a
     * minimum.
     *
     * @param string $message
     * @return void
     */
    abstract public function info($message);

    /**
     * detailed information on the flow through the system. Expect these to be
     * written to logs only.
     *
     * @param string $message
     * @return void
     */
    abstract public function debug($message);

    /**
     * more detailed information. Expect these to be written to logs only.
     *
     * @param string $message
     * @return void
     */
    abstract public function trace($message);

}
