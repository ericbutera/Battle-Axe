<?php
/**
 * Make a mess purdy-like.
 *
 * original:
 * 'This is           the #$@#% title of 12/12/2009-----!'
 *
 * scrubbed:
 * 'this-is-the-title-of-12-12-2009
 *
 * @author eric
 *
 */
class baxe_Util_PurdyString {


    /**
     * Generate the clean string
     *
     * @param string $v
     * @param string $separator
     * @return string
     */
    public static function generate($v, $separator='-') {
        $v = mb_strtolower($v);
        $v = preg_replace('/[^a-z0-9 -]/', ' ', $v);
        $v = preg_replace('/\s+/', $separator, $v);
        $v = preg_replace('|-+|', $separator, $v);
        $v = trim($v, $separator);
        return $v;
    }

}
