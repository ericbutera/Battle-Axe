<?php
class baxe_Authentication_Db_Gateway extends baxe_DAO_GatewayAbstract {

    public function getPrimaryKey() {
        return 'userId';
    }

    public function getTableName() {
        return 'blog_user';
    }

    public function getVoClass() {
        return 'baxe_Authentication_VO';
    }

    /**
     * Try to log the user in
     *
     * @param baxe_Authentication_VO $vo
     * @return baxe_Authentication_VO
     */
    public function login(baxe_Authentication_VO $vo) {
        $sql = "
        SELECT *
        FROM `". $this->getTableName() ."`
        WHERE `email`=:email AND `pass`=:pass
        ";

        $stmt = $this->getDb()->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_INTO, $vo);
        $params = array(':email' => $vo->email, ':pass' => $vo->pass);
        $stmt->execute($params);

        $user = $stmt->fetch(PDO::FETCH_INTO);
        if (!$user instanceof baxe_Authentication_VO) {
            throw new Exception("Unable to log you in.");
        }

        $vo->isValid = true;
    }

}
