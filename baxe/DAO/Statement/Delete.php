<?php
class baxe_DAO_Statement_Delete extends baxe_DAO_Statement_Abstract {

    /**
     * (non-PHPdoc)
     * @see lib/library/baxe/DAO/Statement/baxe_DAO_Statement_Abstract#execute($vo)
     */
    public function execute(baxe_DAO_VOAbstract $vo) {
        $_sql = "DELETE FROM `%s` WHERE `%s`=%s";

        $pk = $this->gateway->getPrimaryKey();
        $namedPk = ":{$pk}";

        $sql  = sprintf($_sql,
            $this->gateway->getTableName(),
            $pk,
            $namedPk
        );

        $stmt = $this->db->prepare($sql);
        $stmt->execute(array(
            $namedPk => $vo->getId()
        ));
    }

}
