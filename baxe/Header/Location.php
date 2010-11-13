<?php
class baxe_Header_Location extends baxe_Header_Abstract {

    public function __construct($url) {
        $this->url = $url;
    }

    public function getKey() {
        return "Location";
    }

    public function render() {
        header('Location: '. $this->escape($this->url));
    }

}
