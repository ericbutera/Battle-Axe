<?php
class baxe_Autoload {

	private $applicationPath;
	private $libraryPath;

	/**
	 * ctor
	 *
	 * @param string $basePath Base path to /lib directory
	 */
	public function __construct($basePath) {
	    $this->libraryPath     = "{$basePath}/library";
	    $this->applicationPath = "{$basePath}/application";
	}

	public function application($file) {
        $class = "/". str_replace("_", "/", $file) .".php";
	    $a = $this->applicationPath ."/domain". $class;
        if (file_exists($a) && (bool)include_once $a) {
            return true;
        }
	}

    /**
     * @param string $file
     * @return bool
     */
    public function library($file) {
        $class = "/". str_replace("_", DIRECTORY_SEPARATOR, $file) .".php";

        if (0 === strncmp($class, '/baxe/', 6)) {
            $l = $this->libraryPath . $class;
            if (file_exists($l) && (bool)include_once $l) {
                return true;
            }
        }
    }

    public function register() {
    	spl_autoload_register(array($this, 'application'));
    	spl_autoload_register(array($this, 'library'));
    }


    public function registerApplication() {
        spl_autoload_register(array($this, 'application'));
    }

    public function registerLibrary() {
        spl_autoload_register(array($this, 'library'));
    }

}
