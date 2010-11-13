<?php
class baxe_Flash_Message {

    protected $messages = array();

    public function add($message) {
        $this->messages[] = $message;
    }

    public function has() {
        return (count($this->messages) > 0);
    }

    public function show() {
        $r = '';
        if (!count($this->messages)) {
            return $r;
        }
        $r .= "<ul>";
        while ($error = array_shift($this->messages)) {
            $r .= "<li>". htmlspecialchars($error, ENT_QUOTES, "UTF-8") ."</li>";
        }
        $r .= "</ul>";
        return $r;
    }

}
