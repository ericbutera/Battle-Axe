<?php
class baxe_App_Web extends baxe_App_Abstract {

    /**
     * Get the controller instance
     *
     * @return baxe_App_Web_Controller_Abstract
     */
    public function getController() {
        if (!$this->controller instanceof baxe_App_Web_Controller_Abstract) {
            $this->controller = new baxe_App_Web_Controller_Front($this);
        }
        return $this->controller;
    }

    /**
     * Get the request
     *
     * @return baxe_App_Web_Request
     */
    public function getRequest() {
        if (!$this->request instanceof baxe_App_Web_Request) {
            $this->request = new baxe_App_Web_Request($this);
        }
        return $this->request;
    }

	/**
	 * @return baxe_App_Web_Response
	 */
	public function getResponse() {
	    if (!$this->response instanceof baxe_App_Web_Response) {
	        $this->response = new baxe_App_Web_Response($this);
	    }
	    return $this->response;
	}

	/**
	 * (non-PHPdoc)
	 * @see baxe_App_Abstract#run($route)
	 */
	public function run($route) {
	    $response = $this->getResponse();
		try {
		    $response->addHeader(new baxe_Header_ContentType(baxe_Header_ContentType::HTML));
            $content = $this->getController()->run($route);
		} catch (baxe_App_Web_Controller_404Exception $e) {
		    $content = $this->renderPageNotFound($response);
		} catch (Exception $e) {
		    error_log($e->getMessage());
		    $content = $this->renderPageError($response);
		}

		// if the controller returned a response content object, then just use it
		// and skip the layout as its probably a file download or such.
        if ($content instanceof baxe_Response_Content_Abstract) {
            $response->setContent($content);
        } else {
    		$layout = $this->getLayout();
    		$layout->addRegion(new baxe_Layout_ContentRegion($content));
    		$response->setContent(new baxe_Response_Content_String($layout->render()));
        }

        echo $response->render();
	}

	/**
	 * Render the content of a 404 page.
	 *
     * @param baxe_App_Web_Response $response
     * @return string
	 */
	private function renderPageNotFound(baxe_App_Web_Response $response) {
        $response->addHeader(new baxe_Header_404);
        $this->getLayout()->setPageTitle("Oh noes!");
        try {
            $view = new baxe_View($this);
            return $view->render('error/notFound.php');
        } catch (Exception $e) {
            return "Oh noes!  You made a 404!";
        }
	}

	/**
	 * Render a friendly error page.  This happens on an uncaught exception
	 * which might have happened from an error like unable to connect to database
	 * or some random fail.
	 *
	 * @param baxe_App_Web_Response $response
	 * @return string
	 */
	private function renderPageError(baxe_App_Web_Response $response) {
        $response->addHeader(new baxe_Header_503);
        $this->getLayout()->setPageTitle("Well hrmph.");
        try {
            $view = new baxe_View($this);
            return $view->render('error/error.php');
        } catch (Exception $e) {
            return "There was a fatal error trying to deliver this page.  Please try again in a bit.";
        }
	}

}
