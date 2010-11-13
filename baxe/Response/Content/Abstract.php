<?php
/**
 * PHP has a lot of different mechanisms for dealing with data.  You can have a
 * raw string or things such as a stream.  This class exists to help ease the
 * pain of working with any of the different data types your application might
 * need to send to the user.
 *
 * Most of the time the Content_String renderer will be fine.  There will come
 * times when you need to be more memory aware.  A good example is file
 * downloads.  You wouldn't want to do file_get_contents() on a 400 meg file.
 * It is way more efficient to use the php function readfile() to prevent the
 * webservers ram from being consumed by one client.
 *
 * This class aims to make working with strings, streams, and large files easier.
 */
abstract class baxe_Response_Content_Abstract {

    /**
     * Render the content directly to the client.  This will NOT return the result.
     *
     * @return void
     */
    abstract public function render();

}
