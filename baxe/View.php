<?php
class baxe_View implements ArrayAccess {


	/**
	 * filesystem path to templates
	 *
	 * @var string
	 */
	private $path;

	/**
	 * filename of template
	 *
	 * @var string
	 */
	private $template;

	/**
	 * view data
	 *
	 * @var array
	 */
	private $data = array();

	/**
	 * @var baxe_App_Abstract
	 */
	private $app;

	public function __construct(baxe_App_Abstract $app) {
		$this->app = $app;
		$this->setPath($app->getApplicationPath() . DIRECTORY_SEPARATOR ."templates");
	}

	/**
	 * set the template filename
	 *
	 * @param string $file
	 */
	public function setTemplate($file) {
		$this->template = $file;
	}

	public function getTemplate() {
		return $this->Template;
	}

	/**
	 * Change the path of the templates
	 *
	 * @param string $path
	 */
	public function setPath($path) {
		$this->path = $path;
	}

	public function getPath() {
		return $this->path;
	}

    /**
     * @param offset
     */
    public function offsetExists($offset) {
    	return isset($this->data[$offset]);
    }

    /**
     * @param offset
     */
    public function offsetGet($offset) {
    	return $this->escape($this->data[$offset]);
    }

    /**
     * @param offset
     * @param value
     */
    public function offsetSet($offset, $value) {
    	$this->data[$offset] = $value;
    }

    /**
     * get a value from the data array
     *
     * @param $offset
     * @return mixed
     */
    public function __get($offset) {
    	if (isset($this->data[$offset])) {
    		return $this->data[$offset];
    	}
    }

    /**
     * @param offset
     */
    public function offsetUnset($offset) {
    	unset($this->data[$offset]);
    }

    /**
     * Render a template
     *
     * @param string $template Template filename
     * @return string
     * @throws Exception
     */
	public function render($template) {
		$this->setTemplate($template);
		$fullpath = $this->path . DIRECTORY_SEPARATOR . $this->template;

		if (!file_exists($fullpath)) {
		    $this->app->getLogger()->error("The template {$fullpath} is not readable.");
			throw new baxe_Exception_FileNotFound("The template (". basename($template) .") is not readable.");
		}

		ob_start();
		include $fullpath;
		return ob_get_clean();
	}

	/**
	 * Escape a scalar value.  Otherwise it will just return what you gave it.
	 *
	 * @param $value
	 * @return string
	 */
	public function escape($value) {
		if (is_scalar($value)) {
    		return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
		}
		return $value;
	}

	/**
	 * Create a link to another action.
	 *
	 * createLink(array('route'=>'/', 'params'=>array('page'=>1), 'absolute'=>false));
	 *
	 * @param array $params
	 * @return string
	 */
	public function createLink(array $params) {
	    // todo make this use the controller's router
	    // $this->app->getController()->getRouter()->createLink();

        $defs = array(
            'route'     => "/",
            'params'    => array(),
            'absolute'  => false
		);

		$params = array_merge($defs, $params);

        if (true === $params['absolute']) {
        	$route = $this->app->getConfig()->config['site.host'] . $params['route'];
        } else {
            $route = $params['route'];
        }

        $qs = '';
        if (count($params['params'])) {
            $qs = "?". http_build_query($params['params']);
        }

        return "{$route}{$qs}";
	}

}
