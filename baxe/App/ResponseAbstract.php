<?php
abstract class baxe_App_ResponseAbstract {

    /**
     * @var baxe_Response_Content_Abstract
     */
    protected $content;

    /**
     * Set the content renderer
     *
     * @param baxe_Response_Content_Abstract $content
     */
    public function setContent(baxe_Response_Content_Abstract $content) {
        $this->content = $content;
    }

    /**
     * Get the current content renderer
     *
     * @return baxe_Response_Content_Abstract
     */
    public function getContent() {
        return $this->content;
    }

    /**
     * Render the response to the client.  Will not return any value.
     *
     * @return void
     */
    abstract public function render();

}
