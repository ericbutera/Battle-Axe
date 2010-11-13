<?php
class baxe_App_Session implements ArrayAccess {

    protected static $blacklist = array(
        "Googlebot",
        "Slurp",
        "Yandex",
        "Baiduspider"
    );

	public function __construct() {}

	public function __destruct() {
	    if ($this->isStarted()) {
	        $this->stop();
	    }
	}

	public function has($offset) {
	    return isset($_SESSION[$offset]);
	}

	public function get($offset) {
	    return $_SESSION[$offset];
	}

	public function set($offset, $value) {
	    $_SESSION[$offset] = $value;
	}

    /**
     * @param offset
     */
    public function offsetExists($offset) {
    	return isset($_SESSION[$offset]);
    }

    /**
     * @param offset
     */
    public function offsetGet($offset) {
    	return $_SESSION[$offset];
    }

    /**
     * @param offset
     * @param value
     */
    public function offsetSet($offset, $value) {
    	$_SESSION[$offset] = $value;
    }

    /**
     * @param offset
     */
    public function offsetUnset($offset) {
    	unset($_SESSION[$offset]);
    }

	public function start() {
        // do not start a session if the user does not have a user agent that is
	    // at least 7 chars (mozilla) or they are in the blacklist.
	    if (!isset($_SERVER['HTTP_USER_AGENT']) ||
	        strlen($_SERVER['HTTP_USER_AGENT']) < 7 ||
            in_array($_SERVER['HTTP_USER_AGENT'], self::$blacklist)
        ) {
            return;
        }

        if (true === headers_sent() ||
		    true !== session_start()
        ) {
			throw new Exception("Unable to start session.");
		}
	}

	public function stop() {
	   session_write_close();
	}

	public function destroy() {
		session_destroy();
	}

	/**
	 * @param $id
	 * @return string
	 */
	public function id($id=null) {
		if (null !== $id) {
			return session_id($id);
		}
		return session_id();
	}

	/**
	 * Is there an active session?
	 *
	 * @return bool
	 */
	public function isStarted() {
	    return (bool)session_id();
	}

	/**
	 * @param $deleteOldSession
	 * @return bool
	 */
	public function regenerateId($deleteOldSession=false) {
		return session_regenerate_id($deleteOldSession);
	}

}
