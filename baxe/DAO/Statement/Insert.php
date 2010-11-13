<?php
class baxe_DAO_Statement_Insert extends baxe_DAO_Statement_Abstract {

    private $bind = array();

    /**
     * @param baxe_DAO_VOAbstract $vo
     * @return string
     */
    protected function sql(baxe_DAO_VOAbstract $vo) {
        $_sql = "INSERT INTO `%s`\n (%s) \nVALUES\n (%s)";

        $defaultProperties  = get_class_vars($this->gateway->getVOClass());
        $properties         = get_object_vars($vo);
        $pk                 = $this->gateway->getPrimaryKey();

        unset($defaultProperties[$pk]);
        unset($properties[$pk]);

        $k = array();
        $v = array();
        foreach ($defaultProperties as $property => $defValue) {
            $named = ":{$property}";
            $k[] = "`{$property}`";
            $v[] = $named;
            $this->bind[$named] = $properties[$property];
        }

        $sql  = sprintf($_sql,
            $this->gateway->getTableName(),
            implode(", ", $k),
            implode(", ", $v)
        );

        return $sql;
    }

    /**
     * (non-PHPdoc)
     * @see lib/library/baxe/DAO/Statement/baxe_DAO_Statement_Abstract#execute($vo)
     */
    public function execute(baxe_DAO_VOAbstract $vo) {
        $stmt = $this->db->prepare( $this->sql($vo) );
        $stmt->execute($this->bind);
        $pk = $this->gateway->getPrimaryKey();
        $vo->{$pk} = $this->db->lastInsertId();
    }

}
