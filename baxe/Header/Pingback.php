<?php
/**
 * This will construct a pingback header.
 *
 * header('X-Pingback: http://example.com/xmlrpc');
 */
class baxe_Header_Pingback extends baxe_Header_Abstract {

    const KEY = 'X-Pingback';

    /**
     * @var string
     */
    private $url;

    /**
     * ctor
     *
     * @param string $url Pingback service url
     */
    public function __construct($url) {
        $this->url = $url;
    }

    public function getKey() {
        return self::KEY;
    }

    public function render() {
        header(self::KEY .": ". $this->url);
    }

}
