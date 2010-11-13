<?php
/**
 * This will construct a Content-type: header
 *
 * header('Content-Type: text/html; charset=utf-8');
 */
class baxe_Header_ContentType extends baxe_Header_Abstract {

    const HTML = 'text/html';
    const XML  = 'text/xml';
    const JPEG = 'image/jpeg';
    const PNG  = 'image/png';
    const PDF  = 'application/pdf';

    const CHARSET_UTF8 = 'utf-8';
    const CHARSET_LATIN1 = 'iso-8859-1'; // gross

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $charset;

    /**
     * ctor
     *
     * @param string $type Content type
     * @param string $charset
     */
    public function __construct($type, $charset=null) {
        $this->type = $type;
        $this->charset = null;
    }

    public function getKey() {
        return "ContentType";
    }

    public function render() {
        $charset = null !== $this->charset ? "; charset=". $this->escape($this->charset) : "";
        header("Content-type: ". $this->escape($this->type) . $charset, true);
    }

}
