<?php
abstract class baxe_Image_Abstract {

    const FORMAT_JPEG = 'jpeg';
    const FORMAT_PNG  = 'png';
    const FORMAT_GIF  = 'gif';

    /**
     * Load an image from a file on disc
     *
     * @param string $path
     * @return void
     * @throws Exception
     */
    abstract public function load($path);

    /**
     * Write the current image to disc
     *
     * @param string $path
     * @return void
     * @throws Exception
     */
    abstract public function save($path);

    /**
     * Get the raw image data.  Useful for displaying a generated image on the
     * fly.
     *
     * @return string
     */
    abstract public function display();

    /**
     * Apply a filter to an image
     *
     * @param baxe_Image_Filter_Abstract $filter
     * @return void
     * @throws Exception
     */
    public function filter(baxe_Image_Filter_Abstract $filter) {
        $filter->process($this);
    }

    /**
     * @return int
     */
    abstract public function getWidth();

    /**
     * @return int
     */
    abstract public function getHeight();

    /**
     * Set the format of this image.
     *
     * @param string $format
     * @return string
     */
    abstract public function setFormat($format);

}
