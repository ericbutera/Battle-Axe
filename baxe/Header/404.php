<?php
class baxe_Header_404 extends baxe_Header_Abstract {

    public function getKey() {
        return "StatusCode";
    }

    public function render() {
        header('HTTP/1.1 404 Not Found');
    }

}
