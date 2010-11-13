<?php
class baxe_DAO_Statement_Load extends baxe_DAO_Statement_Abstract {

    protected $id = 0;

    /**
     * (non-PHPdoc)
     * @see lib/library/baxe/DAO/Statement/baxe_DAO_Statement_Abstract#execute($vo)
     */
    public function execute(baxe_DAO_VOAbstract $vo) {
        $sql = "SELECT * FROM `". $this->gateway->getTableName() ."` WHERE `". $this->gateway->getPrimaryKey() ."`=:pk";
        $stmt = $this->db->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_INTO, $vo);
        $stmt->execute(array(':pk'=>$this->id));
        if (false === $stmt->fetch()) {
            throw new Exception("Unable to load {$this->id}");
        }
    }

    public function setId($id) {
        $this->id = $id;
    }

}
