<?php
/**
 * Service Unavailable.  Send this when you've got something screwed up in your
 * code to make sure google does not cache your broken page in their cache.
 */
class baxe_Header_503 extends baxe_Header_Abstract {

    public function getKey() {
        return "StatusCode";
    }

    public function render() {
        header('HTTP/1.1 503 Service Temporarily Unavailable');
        header('Status: 503 Service Temporarily Unavailable');
        header('Retry-After: '. 60*60);
    }

}
