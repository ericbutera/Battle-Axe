<?php
class baxe_Upload {

    /**
     * Constructor
     */
    public function __construct() {}

    /**
     * Process an uploaded file
     *
     * @param baxe_Upload_HandlerAbstract $handler
     * @return baxe_Upload_File
     * @throws Exception
     */
    public function process(baxe_Upload_HandlerAbstract $handler) {
        $file = $this->createUploadFile($handler);
        $handler->preProcess($file);
        $handler->process($file);
        return $file;
    }

    /**
     * Is there an upload for this handler?
     *
     * @param $handler
     * @return bool
     * @throws Exception
     */
    public function has(baxe_Upload_HandlerAbstract $handler) {
        $k = $handler->getField();

        if (!isset($_FILES[$k]) ||
            0 == $_FILES[$k]['size'] ||
            UPLOAD_ERR_NO_FILE == $_FILES[$k]['error']
        ) {
            return false;
        }

        return true;
    }

    /**
     * @param baxe_Upload_HandlerAbstract $handler
     * @return baxe_Upload_File
     * @throws Exception
     */
    private function createUploadFile(baxe_Upload_HandlerAbstract $handler) {
        $file = new baxe_Upload_File;
        $k    = $handler->getField();

        $file->name     = $_FILES[$k]['name'];
        $file->rawName  = $_FILES[$k]['name'];
        $file->rawType  = $_FILES[$k]['type'];
        $file->size     = $_FILES[$k]['size'];
        $file->tempName = $_FILES[$k]['tmp_name'];
        $file->error    = $_FILES[$k]['error'];

        if (UPLOAD_ERR_OK !== $_FILES[$k]['error']) {
            switch ($_FILES[$k]['error']) {
                case UPLOAD_ERR_INI_SIZE:
                    throw new Exception('The file you uploaded exceeds the maximum size of '. number_format($this->maxUploadSize(), 0, '', ',') .'.');
                    break;

                default:
                    throw new Exception("There was error uploading the file.");
                    break;
            }
        }

        $this->validateMime($handler, $file);

        return $file;
    }

    /**
     * Get the maximum size an upload can be in bytes
     *
     * @return int
     */
    private function maxUploadSize() {
        $f = $this->convertShorthandToBytes(ini_get('upload_max_filesize'));
        $p = $this->convertShorthandToBytes(ini_get('post_max_size'));
        if ($p) {
            return min($f, $p);
        } else {
            return $f;
        }
    }

    /**
     * Take a value such as 5M and change it into 5000000. [taken from php.net]
     *
     * @param string $val
     * @return int
     */
    private function convertShorthandToBytes($val) {
        $val  = trim($val);
        $last = strtolower($val[strlen($val)-1]);
        switch ($last) {
            case 'g':
            $val *= 1024;
            case 'm':
            $val *= 1024;
            case 'k':
            $val *= 1024;
        }
        return $val;
    }

    /**
     * Checks the handlers mime types against what was uploaded.
     *
     * @param baxe_Upload_HandlerAbstract $handler
     * @param baxe_Upload_File $file
     * @return void
     * @throws Exception
     */
    private function validateMime(baxe_Upload_HandlerAbstract $handler, baxe_Upload_File $file) {
        $mimes = $handler->getMimes();
        if (! function_exists('mime_content_type')) {
            trigger_error("Unable to validate your file mime type.");
            throw new Exception("Unable to validate your file mime type.");
        }

        $mime = mime_content_type($file->tempName);
        if (!in_array($mime, $mimes)) {
            throw new Exception("The mime type ". $mime ." is invalid for file ". $file->rawName .".");
        }

        $file->type = $mime;
    }

    /**
     * Static method to return valid image mime types
     *
     * @return array
     */
    public static function getImageMimes() {
        return array('image/jpeg', 'image/jpeg', 'image/png', 'image/gif');
    }

}
