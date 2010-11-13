<?php
class baxe_Util_PhpFileFilter extends FilterIterator {
    public function accept() {
        $current = (string)$this->current();
        if (substr($current, -4) != '.php') {
            return false;
        }
        return true;
    }
}
