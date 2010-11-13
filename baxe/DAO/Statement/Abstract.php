<?php
abstract class baxe_DAO_Statement_Abstract {

    /**
     * @var baxe_App_Abstract
     */
    protected $app;

    /**
     * @var PDO
     */
    protected $db;

    /**
     * @var baxe_DAO_GatewayAbstract
     */
    protected $gateway;

    /**
     * ctor
     *
     * @param baxe_App_Abstract $db
     * @param baxe_DB_GatewayAbstract $gateway
     */
    public function __construct(baxe_App_Abstract $app, baxe_DAO_GatewayAbstract $gateway) {
        $this->app      = $app;
        $this->db       = $app->getDatabase();
        $this->gateway  = $gateway;
    }

    /**
     * Generate and execute the statement
     *
     * @param baxe_DB_VOAbstract $vo
     * @return void
     * @throws Exception
     */
    abstract public function execute(baxe_DAO_VOAbstract $vo);

}
