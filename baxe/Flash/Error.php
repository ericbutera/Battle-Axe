<?php
class baxe_Flash_Error {

    protected $errors = array();

    /**
     * @param string $error
     */
    public function add($error) {
        $this->errors[] = $error;
    }

    /**
     * @return bool
     */
    public function has() {
        return (count($this->errors) > 0);
    }

    /**
     * @return string
     */
    public function show() {
        $r = '';
        if (!count($this->errors)) {
            return $r;
        }
        $r .= "<ul>";
        while ($error = array_shift($this->errors)) {
            $r .= "<li>". htmlspecialchars($error, ENT_QUOTES, "UTF-8") ."</li>";
        }
        $r .= "</ul>";
        return $r;
    }

}
