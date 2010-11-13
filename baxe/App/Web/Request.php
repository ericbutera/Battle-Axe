<?php
class baxe_App_Web_Request {

    const GLOBALS = 'GLOBALS';
    const GET     = 'GET';
    const POST    = 'POST';
    const PUT     = 'PUT';
    const DELETE  = 'DELETE';
    const COOKIE  = 'COOKIE';
    const SERVER  = 'SERVER';
    const ENV     = 'ENV';

    private $data = array();

    /**
     * Return the request METHOD
     *
     * @return self::(GET|POST|PUT|DELETE)
     */
    public function getMethod() {
        return strtoupper($_SERVER['REQUEST_METHOD']);
    }

    /**
     * Get $_POST
     *
     * @return array
     */
    public function getPost() {
        return $this->getSource(self::POST);
    }

    /**
     * Get a filtered value
     *
     * @param baxe_Validator_Interface $validator
     * @param string $key Key in source
     * @param string $source Source of data, GET, POST, COOKIE, etc
     * @param mixed $default Default value to use if not set or validation fails
     * @return mixed
     */
    public function getFiltered(baxe_Validator_Interface $validator, $key, $source, $default=null) {
        $data = $this->getSource($source);
        if (isset($data[$key])) {
            return $validator->process($data[$key], $default);
        }
        return $default;
    }


    /**
     * Do not use these raw unless you know what youre doing.
     *
     * @param $source
     * @return mixed
     * @throws Exception
     */
    public function getSource($source) {
        switch ($source) {
            case self::GET:
                return $_GET;
                break;

            case self::POST:
                return $_POST;
                break;

            case self::COOKIE:
                return $_COOKIE;
                break;

            case self::SERVER:
                return $_SERVER;
                break;

            case self::ENV:
                return $_ENV;
                break;

            case self::GLOBALS:
                return $GLOBALS;
                break;

            case self::PUT:
                return file_get_contents('php://input');
                break;
        }
        throw new Exception("Invalid source {$source}");
    }

}
