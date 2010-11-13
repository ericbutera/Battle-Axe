<?php
abstract class baxe_Crypt_Abstract {

    /**
     * @var baxe_App_Abstract
     */
    protected $app;

    public function __construct(baxe_App_Abstract $app) {
        $this->app = $app;
    }

    abstract public function encrypt($data);
}
