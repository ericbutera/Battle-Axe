<?php
class baxe_Layout {

	/**
	 * @var baxe_App_Abstract
	 */
	protected $app;

	/**
	 * path on filesystem to layout files
	 *
	 * @var string
	 */
	protected $layoutPath;

	/**
	 * specific layout filename to use
	 *
	 * @var string
	 */
	protected $layoutFile = "default.php";

	public $pageTitle = "Untitled";

	protected $meta = array();

	/**
	 * region objects
	 *
	 * @var array<baxe_Layout_RegionAbstract>
	 */
	protected $regions = array();

	public function __construct(baxe_App_Abstract $app) {
		$this->app        = $app;
		$this->layoutPath = $app->getApplicationPath() . DIRECTORY_SEPARATOR ."layouts";

        $this->view = new baxe_View($this->app);
        $this->view->setPath($this->layoutPath);
        $this->view->config = $this->app->getConfig();
        $this->view->layout = $this;
	}

	/**
	 * set the layout template filename
	 *
	 * @param string $file
	 * @throws baxe_Exception_FileNotFound
	 */
	public function setLayoutFile($file) {
		if (!file_exists($this->layoutPath . DIRECTORY_SEPARATOR . $file)) {
			throw new baxe_Exception_FileNotFound("The file {$this->layoutPath}/{$file} does not exist.");
		}
		$this->layoutFile = $file;
	}


	public function addRegion(baxe_Layout_RegionAbstract $region) {
		$this->regions[$region->getId()] = $region;
	}


	/**
	 * render the layout into a string
	 *
	 * @return string
	 * @throws Exception
	 */
	public function render() {
		foreach ($this->regions as $id => $region) {
			/* @var $region baxe_Layout_RegionAbstract */
			$this->view[$id] = $region->render();
		}

		$this->view->flash  = $this->app->getFlash();
		return $this->view->render($this->layoutFile);
	}


	public function setPageTitle($value) {
		$this->pageTitle = $value;
	}

	public function getPageTitle() {
		return $this->pageTitle;
	}


	/**
	 * Add a meta tag
	 *
	 * @param array $parts
	 */
	public function addMeta(array $parts) {
	    $this->meta[] = $parts;
	}


	public function renderMeta() {
	    $r = "";
	    foreach ($this->meta as $meta) {
	        $r .= '<meta ';
	        foreach ($meta as $k => $v) {
	           $r .= $k  .'="'. $v .'" ';
	        }
	        $r .= '/>';
	    }
	    return $r;
	}

}
