<?php
class baxe_Validator_Int implements baxe_Validator_Interface {

    private $min=null;
    private $max=null;

    /**
     * @param int $min Optional minimum
     * @param int $max Optional maximum
     */
    public function __construct($min=null, $max=null) {
        $this->min = $min;
        $this->max = $max;
    }

    /**
     * (non-PHPdoc)
     * @see lib/library/baxe/Validator/baxe_Validator_Interface#process($data, $default)
     */
    public function process($data, $default=null) {
        $options = array(
            'default'=>$default
        );

        if (null !== $this->min) {
            $options['min_range'] = $this->min;
        }

        if (null !== $this->max) {
            $options['max_range'] = $this->max;
        }

        return filter_var($data, FILTER_VALIDATE_INT, $options);
    }
}
