<?php
interface baxe_Validator_Interface {

    /**
     * Process the information
     *
     * @param mixed $data    Scalar value
     * @param mixed $default Optional default to use if validation fails
     * @return mixed
     */
    public function process($data, $default=null);

}
