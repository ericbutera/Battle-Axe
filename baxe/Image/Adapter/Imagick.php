<?php
class baxe_Image_Adapter_Imagick extends baxe_Image_Abstract {

    /**
     * @var Imagick
     */
    private $imagick;

    /**
     * @return Imagick
     */
    public function getImagick() {
        if (!$this->imagick instanceof Imagick) {
            throw new baxe_Image_Exception("There is not an imagick resource.");
        }
        return $this->imagick;
    }

    public function setImagick(Imagick $imagick) {
        $this->imagick = $imagick;
    }

    /**
     * (non-PHPdoc)
     * @see Image/baxe_Image_Abstract#load($path)
     */
    public function load($path) {
        $this->setImagick(new Imagick($path));
    }

    /**
     * (non-PHPdoc)
     * @see Image/baxe_Image_Abstract#save($path)
     */
    public function save($path) {
        $this->getImagick()->writeImage($path);
    }

    /**
     * (non-PHPdoc)
     * @see Image/baxe_Image_Abstract#display()
     */
    public function display() {
        $this->getImagick()->getImageBlob();
    }

    /**
     * (non-PHPdoc)
     * @see Image/baxe_Image_Abstract#getWidth()
     */
    public function getWidth() {
        return $this->getImagick()->getImageWidth();
    }

    /**
     * (non-PHPdoc)
     * @see Image/baxe_Image_Abstract#getHeight()
     */
    public function getHeight() {
        return $this->getImagick()->getImageHeight();
    }

    public function setFormat($format) {
        $this->getImagick()->setImageFormat($format);
    }

}
