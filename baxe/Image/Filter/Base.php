<?php
class baxe_Image_Filter_Base extends baxe_Image_Filter_Abstract {

    public function process(baxe_Image_Abstract $image) {
        baxe_Image_Filter_Factory::factory(get_class($this), $image)
            ->process($image);
    }

}
