<?php
class baxe_Authentication_Db extends baxe_Authentication_Abstract {

    /**
     * (non-PHPdoc)
     * @see lib/library/baxe/Authentication/baxe_Authentication_Abstract#login()
     */
    public function login(baxe_Authentication_VO $vo) {
        $vo->pass = $this->getCrypt()->encrypt($vo->pass);

        $gateway = new baxe_Authentication_Db_Gateway($this->app);
        $gateway->login($vo);
    }

}
