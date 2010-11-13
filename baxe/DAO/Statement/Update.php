<?php
class baxe_DAO_Statement_Update extends baxe_DAO_Statement_Abstract {

    private $bind = array();

    /**
     * @param baxe_DAO_VOAbstract $vo
     * @return string
     */
    protected function sql(baxe_DAO_VOAbstract $vo) {
        $_sql = "UPDATE `%s` \nSET %s \nWHERE `%s`=%s";

        $defaultProperties  = get_class_vars($this->gateway->getVOClass());
        $properties         = get_object_vars($vo);
        $pk                 = $this->gateway->getPrimaryKey();

        unset($defaultProperties[$pk]);
        unset($properties[$pk]);

        $pairs = array();
        foreach ($defaultProperties as $property => $defValue) {
            $named = ":{$property}";
            $pairs[] = "`{$property}`={$named}";
            $this->bind[$named] = $properties[$property];
        }

        $pkName = $this->gateway->getPrimaryKey();

        $sql = sprintf($_sql,
            $this->gateway->getTableName(),
            implode(", ", $pairs),
            $pkName,
            ":{$pkName}"
        );

        $this->bind[":{$pkName}"] = $vo->getId();

        return $sql;
    }

    /**
     * (non-PHPdoc)
     * @see lib/library/baxe/DAO/Statement/baxe_DAO_Statement_Abstract#execute($vo)
     */
    public function execute(baxe_DAO_VOAbstract $vo) {
        $stmt = $this->db->prepare( $this->sql($vo) );
        $stmt->execute($this->bind);
    }

}
