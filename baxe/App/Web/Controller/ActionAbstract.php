<?php
abstract class baxe_App_Web_Controller_ActionAbstract {

	/**
	 * @var baxe_App_Web_Controller_Abstract
	 */
	protected $controller;

	/**
	 * @var baxe_App_Web
	 */
	protected $app;

	/**
	 * @var baxe_App_Web_Response
	 */
	protected $response;

    /**
     * Initialize the controller
     *
     * @param baxe_App_Web_Controller_Abstract $controller
     * @param baxe_App_Web $app
     */
    public function __construct(baxe_App_Web_Controller_Abstract $controller, baxe_App_Web $app) {
        $this->controller = $controller;
        $this->app        = $app;
        $this->response   = $app->getResponse();
    }

	/**
	 * @return baxe_App_Web_Controller_Abstract
	 */
	public function getController() {
		return $this->controller;
	}

    /**
     * @return baxe_App_Web
     */
    public function getApp() {
        return $this->app;
    }

	/**
	 * Helper method for changing the layout class
	 *
	 * @return void
	 */
	public function setLayoutClass() {
        // trick for changing the layout template on the fly:
        $this->app->getConfig()->config['layout.class'] = 'baxe_Layout';
	}

	/**
	 * Get the view for this controller.  This is just for convenience.
	 *
	 * @return baxe_View
	 */
	public function getView() {
		$view = new baxe_View($this->app);
		//$view->setPath($this->app->getApplicationPath() . DIRECTORY_SEPARATOR ."templates");
		return $view;
	}

	public function getLayout() {
		return $this->app->getLayout();
	}

	/**
	 * @return baxe_App_Web_Response
	 */
	public function getResponse() {
	    return $this->response;
	}

	public function indexAction() {
		throw new Exception("No index action has been defined in ". get_class($this) .".");
	}

	/**
	 * Override this to provide a way to intercept the request and process it.
	 * If this method returns a string it will override the normal action.  That
	 * is useful if you want to forward in a preDispatch instead of executing
	 * the normal routes action.
	 *
	 * @return mixed
	 * @throws Exception
	 */
	public function preDispatch() {}

}
