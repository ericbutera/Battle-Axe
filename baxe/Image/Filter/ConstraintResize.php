<?php
class baxe_Image_Filter_ConstraintResize extends baxe_Image_Filter_Abstract {

    const WIDTH = 'width';
    const HEIGHT = 'height';

    /**
     * @var string
     */
    protected $side;

    /**
     * @var int
     */
    protected $size = 0;

    /**
     * @param string $side Side self::WIDTH|self::HEIGHT
     * @param int    $size Image size
     */
    public function __construct($side, $size) {
        $this->side = $side;
        $this->size = $size;
    }

    public function process(baxe_Image_Abstract $image) {
        $class  = baxe_Image_Filter_Factory::getFilterClassName(get_class($this), $image);
        $filter = new $class($this->side, $this->size);
        $filter->process($image);
    }

}
