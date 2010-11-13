<?php
class baxe_App_Web_Response extends baxe_App_ResponseAbstract {

    /**
     * @var baxe_App_Web
     */
    protected $app;

    /**
     * @var array
     */
    protected $headers = array();

    /**
     * ctor
     *
     * @param baxe_App_Web $app
     * @return void
     */
    public function __construct(baxe_App_Web $app) {
        $this->app = $app;
    }

    /**
     * Add a baxe wrapped HTTP header
     *
     * @param baxe_Header_Abstract $header
     * @return void
     */
    public function addHeader(baxe_Header_Abstract $header) {
        $this->headers[$header->getKey()] = $header;
    }

    /**
     * Send HTTP headers to the client
     *
     * @return void
     */
    protected function renderHeaders() {
        foreach ($this->headers as $header) {
            $header->render();
        }
    }

    /**
     * (non-PHPdoc)
     * @see App/baxe_App_ResponseAbstract#render()
     */
    public function render() {
        $this->renderHeaders();
        $this->content->render();
    }

}
