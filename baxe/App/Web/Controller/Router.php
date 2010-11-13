<?php
class baxe_App_Web_Controller_Router {

	/**
	 * Raw route string
	 *
	 * @var string
	 */
	private $route = "";

	/**
	 * Controller
	 *
	 * @var string
	 */
	private $controllerName = "defaultController";

	/**
	 * Action
	 *
	 * @var string
	 */
	private $actionName = "indexAction";

	/**
	 * @var baxe_App_Abstract
	 */
	private $app;

	/**
	 * @var baxe_App_Web_Controller_Abstract
	 */
	private $controller;

	/**
	 * @param baxe_App_Web_Controller_Abstract $controller
	 * @param baxe_App_Abstract $app
	 */
	public function __construct(baxe_App_Web_Controller_Abstract $controller, baxe_App_Abstract $app) {
	    $this->controller  = $controller;
	    $this->app         = $app;
	}

	/**
	 * Create a controller action callback for a given route
	 *
	 * @param string $route "/" "/manage"
	 * @return callback
	 * @throws Exception
	 */
	public function getActionInstance($route) {
        $this->route = "/". trim($route, '/');

        // this uses kt's bikes_Router to make those mappable urls
        if (!$mapper = apc_fetch('baxe.app.web.controller.mapper')) {
            $mapper = new baxe_App_Web_Controller_Mapper;
            $mapper->map("/post/view/:slug", array('controller' => '/post/view'));
            $mapper->map("/sitemap.xml", array('controller' => '/sitemap/xml'));
            apc_store('baxe.app.web.controller.mapper', $mapper, 3600);
        }

        $match = $mapper->match($this->route);
        if (is_array($match)) {
            $this->route = $match['controller'];
            unset($match['controller'], $match['action']);
            $_GET = array_merge($_GET, $match);
        }

        if (!$routes = apc_fetch('baxe.app.web.controller.routes')) {
           $routes = $this->generateControllerCache();
           apc_store('baxe.app.web.controller.routes', $routes, 60*60);
        }

        if (isset($routes[$this->route])) {
            $route = $routes[$this->route];
            require_once $route['file'];
            $instance = new $route['class']($this->controller, $this->app);
            return array($instance, $route['action']);
        }

        $m = "The route {$this->route} does not exist.";
        $this->app->getLogger()->error($m);
        throw new baxe_App_Web_Controller_404Exception($m);
	}

	/**
	 * Get the current route the router has calculated it needs to run based on
	 * getActionInstance.
	 *
	 * @return string
	 */
	public function getRoute() {
	    return $this->route;
	}

	/**
	 * Generate an array of route to controller->action mappings.
	 *
	 * @return array
	 */
    private function generateControllerCache() {
        $generated = array();

        $paths = $this->controller->getControllerPaths();
        foreach ($paths as $path) {
            $files = new baxe_Util_PhpFileFilter(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path)));
            foreach($files as $file) {
                $fullpath       = $file->getPathname();
                $offset         = substr($fullpath, strlen($path));
                $requestPath    = substr($offset, 0, strlen($offset)-14);

                include_once $fullpath;
                $buffer = file_get_contents($fullpath);

                // this should probably be changed to say class_exists(computed-name-based-on-filepath)
                $pattern    = "/class (.*)Controller extends/mU";
                if (preg_match_all($pattern, $buffer, $matches)) {
                    $classBaseName = $matches[1][0];

                    $r = new ReflectionClass("{$classBaseName}Controller");
                    foreach ($r->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
                        /* @var $method ReflectionMethod */
                        $class  = $method->class;
                        $action = substr($method->name, -6);
                        if ('Action' !== $action) {
                            continue;
                        }
                        $this->app->getLogger()->error("Request:'{$requestPath}' Class:'{$class}' Method:'{$method->name}'");

                        $action = substr($method->name, 0, strlen($method->name)-6);

                        // matches defaultController->indexAction
                        if ($this->controllerName === substr($class, -strlen($this->controllerName)) &&
                            $this->actionName === $method->name
                        ) {
                            $rp = dirname($requestPath);
                            // echo "Default controller detected {$rp}<br>";
                            $generated[$rp] = array(
                                'file'      => $fullpath,
                                'class'     => $class,
                                'action'    => $method->name,
                            );
                        // matches *Controller->indexAction
                        } else if ($this->actionName === $method->name) {
                            $rp = $requestPath;
                            // echo "Controller with default action detected {$rp}<br>";
                            $generated[$rp] = array(
                                'file'      => $fullpath,
                                'class'     => $class,
                                'action'    => $method->name,
                            );
                        } else {
                            $rp = "$requestPath/$action";
                            $generated["$requestPath/$action"] = array(
                                'file'      => $fullpath,
                                'class'     => $class,
                                'action'    => $method->name,
                            );
                        }

                        $this->app->getLogger()->error("Adding request path: '{$rp}')");
                    }
                }
            }
        }
        return $generated;
    }

}
