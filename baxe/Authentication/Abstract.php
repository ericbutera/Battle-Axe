<?php
/**
 * @todo http://www.jasonashdown.co.uk/cl_auth_doc/features.php
 *
 * @author eric
 *
 */
abstract class baxe_Authentication_Abstract {

    /**
     * @var baxe_App_Abstract
     */
    protected $app;

    /**
     * @var baxe_Crypt_Abstract
     */
    protected $crypt;

    /**
     * @param baxe_App_Abstract $app
     */
    public function __construct(baxe_App_Abstract $app) {
        $this->app = $app;
    }

    /**
     * Get the storage container for authentication
     *
     * @return baxe_Authentication_VO
     */
    public function getAuthenticationVO(array $data=array()) {
        $session = $this->app->getSession();
        if (!$session['baxe.authentication'] instanceof baxe_Authentication_VO) {
            $this->reset();
        }

        if (null !== $data) {
            $this->loadFromArray($session['baxe.authentication'], $data);
        }

        return $session['baxe.authentication'];
    }

    /**
     * Reset the authenticated user
     *
     * @return void
     */
    public function reset() {
        $session = $this->app->getSession();
        $session['baxe.authentication'] = new baxe_Authentication_VO;
    }

    /**
     * @return baxe_Crypt_Abstract
     */
    public function getCrypt() {
        if (!$this->crypt instanceof baxe_Crypt_Abstract) {
            // $this->crypt = new baxe_Crypt_Sha512($this->app);
            $config = $this->app->getConfig();
            $class  = $config->config['crypt.driver'];
            $this->crypt = new $class($this->app);
        }
        return $this->crypt;
    }

    /**
     * @param baxe_Crypt_Abstract $crypt
     */
    public function setCrypt(baxe_Crypt_Abstract $crypt) {
        $this->crypt = $crypt;
    }

    /**
     * @return bool
     */
    public function isValid() {
        $vo = $this->getAuthenticationVO();
        return $vo->isValid;
    }

    /**
     * Attempt to login
     *
     * @param baxe_Authentication_VO $vo
     * @return void
     * @throws Exception
     */
    abstract public function login(baxe_Authentication_VO $vo);

    /**
     * Logout
     *
     * @return void
     */
    public function logout() {
        $vo = $this->getAuthenticationVO();
        $vo = new baxe_Authentication_VO;
    }

    /**
     * Load an auth vo struct from array data
     *
     * @param baxe_Authentication_VO $vo
     * @param array $data
     */
    public function loadFromArray(baxe_Authentication_VO $vo, array $data) {
        $props = get_class_vars('baxe_Authentication_VO');
        $match = array_intersect(array_keys($props), array_keys($data));
        foreach ($match as $prop) {
            $vo->{$prop} = $data[$prop];
        }
    }

}
