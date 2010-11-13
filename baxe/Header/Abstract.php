<?php
/**
 * Bringing sanity to the madness that is dealing w/ http headers in php.
 */
abstract class baxe_Header_Abstract {

    /**
     * Render a header.  This should internally call the php header() function.
     *
     * @return string
     */
    abstract public function render();

    /**
     * This will return the key for this header class to make sure if you add a
     * 404 header and then a 200 header, the 200 will be able to overwrite the
     * 404 since they will both share the common "StatusCode" key.
     *
     * @return string
     */
    abstract public function getKey();

    /**
     * Try and make sure the http header is escaped to prevent header injection
     *
     * @param string $value
     * @return string
     */
    public function escape($value) {
        $v = trim($value);
        $v = str_replace(array("\n", "\r"), array("", ""), $v);
        return htmlentities($v, ENT_QUOTES, 'UTF-8');
    }

}
