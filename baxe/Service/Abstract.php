<?php
abstract class baxe_Service_Abstract {

    /**
     * @var baxe_App_Abstract
     */
    protected $app;

    /**
     * @param int $id
     * @return baxe_DAO_VOAbstract
     */
    public function load($id) {
        $gateway = new $gatewayName($this->app);
        $voClass = $gateway->getVoClass();
        $vo = new $voClass;
        return $gateway->load($id);
    }

}
