<?php
/**
 * A horde-like router
 * How this router functions was derived from Horde Routes. The goal was to
 * create a router that worked similar but integrated with APC and had a
 * smaller class footprint.
 *
 * @class bikes_Router
 * @package BikesFW
 * @version $id$
 * @copyright 2009 BikesFW, Bikes Framework, Kyle Terry
 * @author Kyle Terry <kyle@kyleterry.com>
 * @license BSD (Inlcuded)
 */
class baxe_App_Web_Controller_Mapper {

    /**
     * There only needs to be one instance of this class
     *
     * @var bikes_Router
     * @access private
     */
    private static $instance;

    /**
     * Holds an instance of bikes_App
     *
     * @var bikes_App $app
     * @access protected
     */
    protected $app;

    /**
     * Holds the mapped routes and their array of default data
     *
     * @var array $routes
     * @access protected
     */
    protected $routes = array();

    /**
     * Holds the default controller the match will return
     *
     * @var string $controller
     * @access protected
     */
    protected $controller;

    /**
     * Holds the default action the match will return
     *
     * @var string $action
     * @access protected
     */
    protected $action = 'index';

    /**
     * Holds the matched uri
     *
     * @var array $match
     * @access protected
     */
    protected $match = array();

    /**
     * Holds the exploded request URI
     *
     * @var array $rawUri
     * @access protected
     */
    protected $rawUri = array();

    /**
     * This is a count to make sure the mapped route and it's array of defaults
     * are indexed right.
     * DO NOT MODIFY
     *
     * @var integer $count
     * @access private
     */
    private $count = 0;

    /**
     * Sets a route that will be checked by match later on
     *
     * @param string $wanted
     * @param array $defaults
     * @access public
     * @return void
     */
    public function map($wanted, $defaults = null){
        $this->routes[$this->count]['uri'] = $this->parseStringUri($wanted);
        if(!empty($defaults)){
            $this->routes[$this->count]['defaults'] = $defaults;
        }
        $this->count++;
    }

    /**
     * Cleans up the URI and explodes it into an array
     *
     * @param string $uri
     * @access protected
     * @return void
     */
    protected function parseStringUri($uri){
        $uri = trim($uri, '/');
        $uri = explode('/', $uri);

        return $uri;
    }

    /**
     * Sets a default controller to use if the mapper isn't passed a defaults array
     *
     * @param string $controller
     * @access public
     * @return void
     */
    public function setController($controller){
        $this->controller = $controller;
    }

    /**
     * Sets a default action to use if the mapper isn't passed a defaults array
     *
     * @param string $action
     * @access public
     * @return void
     */
    public function setAction($action){
        $this->action = $action;
    }

    /**
     * Hands over the matched URI.
     *
     * @access public
     * @return void
     */
    public function getMatch(){
        if(empty($this->match)){
            return false;
        }
        return $this->match;
    }

    /**
     * getUnmatched
     *
     * @access public
     * @return void
     */
    public function getUnmatched(){
        return $this->rawUri;
    }

    /**
     * Matches a request URI passed in against URIs that were mapped.
     *
     * <code>
     * $r = new bikes_Router();
     * $r->map('/:controller/:action/:slug/');
     * $r->map('/articles/:slug/', array('controller' => 'post', 'action' => 'view');
     * $r->match('/articles/some-really-cool-slug/');
     * </code>
     * returns...
     * <code>
     * array
     *  'controller' => string 'post' (length=4)
     *  'action' => string 'view' (length=4)
     *  'slug' => string 'some-really-cool-slug' (length=21)
     * </code>
     *
     * @param string $requestUri
     * @access public
     * @return mixed
     */
    public function match($requestUri) {
        $request = $this->parseStringUri($requestUri);
        $this->rawUri = $request;
        foreach($this->routes as $id => $route){
            if(count($route['uri']) !== count($request)){
                continue;
            }

            $match = array();
            $i = 0;
            foreach($route['uri'] as $part){
                if($part === $request[$i]){
                    $i++;
                    continue;
                } elseif(substr($part, 0, 1) !== ':'){
                    continue 2;
                } else {
                    $match[substr($part, 1)] = $request[$i];
                    $i++;
                }
            }

            if(!empty($route['defaults'])){
                $match = array_merge($route['defaults'], $match);
            }

            if(empty($match['controller'])){
                $match['controller'] = $this->controller;
            }

            if(empty($match['action'])){
                $match['action'] = $this->action;
            }

            $this->match = $match;
            return $match;
        }
        return false;
    }
}
