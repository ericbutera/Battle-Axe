<?php
class baxe_Image_Filter_ConstraintResize_Imagick extends baxe_Image_Filter_ConstraintResize {

    public function process(baxe_Image_Abstract $image) {
        $preventPixelation = true;

        $dstWidth  = 0;
        $dstHeight = 0;

        $srcWidth  = $image->getWidth();
        $srcHeight = $image->getHeight();

        switch ($this->side) {
            case baxe_Image_Filter_ConstraintResize::WIDTH:
                $dstWidth  = $this->size;
                $dstHeight = round(($dstWidth * $srcHeight) / $srcWidth) ;
                break;
            case baxe_Image_Filter_ConstraintResize::HEIGHT:
                $dstHeight = $this->size;
                $dstWidth  = round(($dstHeight * $srcWidth) / $srcHeight) ;
                break;
        }

        if ($preventPixelation &&
            $this->side == baxe_Image_Filter_ConstraintResize::WIDTH && $srcWidth < $dstWidth ||
            $this->side == baxe_Image_Filter_ConstraintResize::HEIGHT && $srcHeight < $dstHeight
        ) {
            $dstWidth  = $srcWidth;
            $dstHeight = $srcHeight;
        }

        $image->getImagick()->resizeImage($dstWidth, $dstHeight, Imagick::FILTER_LANCZOS, 1);
    }

}
