<?php
/**
 * Abstract application representing Cli & Web.
 */
abstract class baxe_App_Abstract {

	/**
	 * @var baxe_Config
	 */
	protected $config;

	/**
	 * @var PDO
	 */
	protected $database;

	/**
	 * @var baxe_Session
	 */
	protected $session;

	/**
	 * @var baxe_Layout
	 */
	protected $layout;

    /**
     * library path of the codebase
     *
     * @var string
     */
    protected $libraryPath;

    /**
     * app path
     *
     * @var string
     */
    protected $applicationPath;

    /**
     * @var baxe_Flash
     */
    protected $flash;

    /**
     * @var baxe_App_ControllerAbstract
     */
    protected $controller;

    /**
     * @var baxe_Authentication_Abstract
     */
    protected $authentication;

    /**
     * @var baxe_App_RequestAbstract
     */
    protected $request;

    /**
     * @var baxe_App_ResponseAbstract
     */
    protected $response;

    /**
     * @var baxe_Logger
     */
    protected $logger;

    /**
     * ctor
     *
     * @param baxe_Config $config
     */
    public function __construct(baxe_Config $config) {
        $this->setConfig($config);
        $this->libraryPath     = $this->config->config['lib.path'] ."/library";
        $this->applicationPath = $this->config->config['lib.path'] ."/application";
    }

    /**
     * Get the library path of the codebase
     *
     * @return string
     */
    public function getLibraryPath() {
        return $this->libraryPath;
    }

    /**
     * Get the application base path
     *
     * @return string
     */
    public function getApplicationPath() {
        return $this->applicationPath;
    }

    abstract public function run($route);

    public function setConfig(baxe_Config $config) {
    	$this->config = $config;
    }

    /**
     * @return baxe_Config
     */
    public function getConfig() {
    	return $this->config;
    }

    /**
     * Get the database instance
     *
     * @return PDO
     */
    public function getDatabase() {
        if (!$this->database instanceof PDO) {
            $this->database = new PDO(
                $this->config->config['db.dsn'],
                $this->config->config['db.user'],
                $this->config->config['db.pass'],
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION) // , PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
            );
        }
        return $this->database;
    }

    /**
     * Get the session instance
     *
     * @return baxe_App_Session
     */
    public function getSession() {
    	if (!$this->session instanceof baxe_App_Session) {
            $this->session = new baxe_App_Session($this);
            $this->session->start();
    	}
    	return $this->session;
    }

    /**
     * Get the authentication instance
     *
     * @return baxe_Authentication_Abstract
     */
    public function getAuthentication() {
        if (!$this->authentication instanceof baxe_Authentication_Abstract) {
            $this->authentication = baxe_Authentication_Factory::getInstance($this);
        }
        return $this->authentication;
    }

    /**
     *
     * @return baxe_App_ControllerAbstract
     */
    abstract public function getController();

    /**
     *
     * @return baxe_App_RequestAbstract
     */
    abstract public function getRequest();

    /**
     * @return baxe_Layout
     */
    public function getLayout() {
    	if (!$this->layout instanceof baxe_Layout) {
	        $layoutClass = $this->config->config['layout.class'];
	        $this->layout = new $layoutClass($this);
            if (method_exists($this->layout, 'registerRegions')) {
                $this->layout->registerRegions();
            }
    	}
    	return $this->layout;
    }

    /**
     * Set the layout object
     *
     * @param baxe_Layout $layout
     */
    public function setLayout(baxe_Layout $layout) {
    	$this->layout = $layout;
    }

    /**
     * @return baxe_Flash
     */
    public function getFlash() {
        if (!$this->flash instanceof baxe_Flash) {
            $this->flash = new baxe_Flash($this);
        }
        return $this->flash;
    }

    /**
     * @return baxe_Logger_Adapter
     */
    public function getLogger() {
        if (!$this->logger instanceof baxe_Logger_Adapter) {
            $this->logger = baxe_Logger::getInstance($this);
        }
        return $this->logger;
    }

}
