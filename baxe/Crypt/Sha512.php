<?php
/**
 * Sha 512 adapter
 */
class baxe_Crypt_Sha512 extends baxe_Crypt_Abstract {

    public function encrypt($data) {
        $config = $this->app->getConfig();
        if (!isset($config->config['crypt.salt'])) {
            throw new Exception("crypt.salt is not configured.");
        }
        return hash('sha512', $config->config['crypt.salt'] . $data);
    }

}
