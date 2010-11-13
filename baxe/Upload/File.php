<?php
class baxe_Upload_File {

    /**
     * Name of the uploaded file.  This may vary from the rawName since it gets
     * filtered.
     *
     * @var string
     */
    public $name;

    /**
     * Raw name provided by the client
     *
     * @var string
     */
    public $rawName;

    /**
     * Actual mimetype determined using Fileinfo or mime_content_type
     *
     * @var string
     */
    public $type;

    /**
     * The raw mime type provided by the client
     *
     * @var string
     */
    public $rawType;

    /**
     * Filesize
     *
     * @var int
     */
    public $size;

    /**
     * Location of file on disc
     *
     * @var string
     */
    public $tempName;

}
