<?php
/**
 * Used to display error messages and other info messages to the user.
 */
class baxe_Flash {

    /**
     * @var baxe_App_Abstract
     */
    private $app;

    /**
     * @var baxe_App_Session
     */
    private $session;

    /**
     * @var baxe_Flash_Error
     */
    private $error;

    /**
     * @var baxe_Flash_Message
     */
    private $message;

    const ERROR = 'baxe.flash.error';
    const MESSAGE = 'baxe.flash.message';

	public function __construct(baxe_App_Abstract $app) {
	    $this->app = $app;
	    $this->session = $app->getSession();
	}

	/**
	 * @return baxe_Flash_Message
	 */
	public function getMessage() {
        if (!$this->session->has(self::MESSAGE)) {
            $this->session->set(self::MESSAGE, new baxe_Flash_Message);
        }
        $this->message = $this->session->get(self::MESSAGE);
	    return $this->message;
	}

    /**
     * @return baxe_Flash_Error
     */
    public function getError() {
        if (!$this->session->has(self::ERROR)) {
            $this->session->set(self::ERROR, new baxe_Flash_Error);
        }
        $this->error = $this->session->get(self::ERROR);
        return $this->error;
    }

}
