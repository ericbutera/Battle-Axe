<?php
/**
 * Basic content handler that echos the set content to the client.
 */
class baxe_Response_Content_String extends baxe_Response_Content_Abstract {

    /**
     * ctor
     *
     * @param string $content Content to send
     */
    public function __construct($content) {
        $this->content = $content;
    }

    public function render() {
        echo $this->content;
    }

}
