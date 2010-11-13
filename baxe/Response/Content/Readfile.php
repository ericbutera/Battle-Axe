<?php
/**
 * Uses readfile() to send a file from disc to the client.
 */
class baxe_Response_Content_Readfile extends baxe_Response_Content_Abstract {

    /**
     * ctor
     *
     * @param string $path File path
     */
    public function __construct($path) {
        $this->path = $path;
    }

    /**
     * (non-PHPdoc)
     * @see Response/Content/baxe_Response_Content_Abstract#render()
     */
    public function render() {
        readfile($this->path);
    }

}
