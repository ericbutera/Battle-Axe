<?php
class baxe_Image_Filter_Factory {

    private function __construct() {}

    /**
     * Generate a class name that implements the filter for the imaging backing
     * based on the image.  For instance if you're using imagick it will return
     * an imagick filter instead of gd.
     *
     * @param string $filterName
     * @param baxe_Image_Abstract $image
     * @return string
     * @throws Exception
     */
    public function getFilterClassName($filterName, baxe_Image_Abstract $image) {
        switch (get_class($image)) {
            case 'baxe_Image_Adapter_Imagick':
                return "{$filterName}_Imagick";
                break;

            case 'baxe_Image_Adapter_Gd':
                return "{$filterName}_Gd";
                break;

            default:
                throw new baxe_Image_Exception("Filter {$filterName} not found for ". get_class($image) .".");
                break;
        }
    }
}
