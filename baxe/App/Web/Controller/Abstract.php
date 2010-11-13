<?php
abstract class baxe_App_Web_Controller_Abstract extends baxe_App_ControllerAbstract {

    /**
     * @var baxe_App_Web
     */
    protected $app;

    /**
     * @var baxe_App_Web_Controller_Router
     */
    protected $router;

    public function __construct(baxe_App_Web $app) {
        $this->app = $app;
    }

    /**
     * @return baxe_App_Web
     */
    public function getApp() {
        return $this->app;
    }


    /**
     * @return baxe_App_Web_Controller_Router
     */
    public function getRouter() {
        if (!$this->router instanceof baxe_App_Web_Controller_Router) {
            $this->router = new baxe_App_Web_Controller_Router($this, $this->app);
        }
        return $this->router;
    }

    /**
     * @return baxe_App_Web_Request
     */
    public function getRequest() {
        return $this->app->getRequest();
    }

    /**
     * Run the controller
     *
     * @param string $route
     * @return string
     * @throws Exception
     */
    public function run($route) {
        return $this->forward($route);
    }

    /**
     * Forward control to an action & return the rendered result
     *
     * @param string $route
     * @return string
     */
    public function forward($route) {
        $callback = $this->getRouter()->getActionInstance($route);
        $pre = $callback[0]->preDispatch();
        if (is_string($pre)) {
            return $pre;
        }
        return call_user_func($callback);
    }

    /**
     * Issue a header 302 redirect
     *
     * @param string $url
     */
    public function redirect($url) {
        $msg =  ''
             . '<html><head>'
             . '<META HTTP-EQUIV=Refresh CONTENT="1; URL="'. $url .'">'
             . '<title>Redirecting...</title>'
             . '</head>'
             . '<body onLoad="controller_doRedirect();">'
             . '<script language="javascript">window.location = "'. $url .'";</script>'
             . '<a href="'. $url .'">Click here</a> to continue.'
             . '</body></html>'
        ;

        // $url = str_replace(array("\n", "\r"), '', $url);
        // header('Location: '. $url);
        $response = $this->app->getResponse();
        $response->addHeader(new baxe_Header_Location($url));
        $response->setContent(new baxe_Response_Content_String($msg));
        $response->render();
        exit;
    }

    /**
     * Take a given route and redirect using a 302
     *
     * @param string $route
     * @param array  $querystring
     */
    public function redirectToRoute($route, array $querystring=array()) {
        $host = $this->app->getConfig()->config['site.host'];

        $qs = '';
        if (count($querystring)) {
            $qs = "?". http_build_query($querystring);
        }

        $this->redirect("{$host}{$route}{$qs}");
    }

    public function linkTo() {

    }

    public function getControllerPaths() {
        return array(
            $this->app->getApplicationPath() . "/controllers"
        );
    }

}
