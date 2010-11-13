<?php
abstract class baxe_DAO_GatewayAbstract {

    /**
     * string column type
     */
    const TYPE_STRING = 'string';

    /**
     * integer column type
     */
    const TYPE_INT    = 'int';

    /**
     * float column type
     */
    const TYPE_FLOAT  = 'float';

    /**
     * bool column type
     */
    const TYPE_BOOL   = 'bool';

    /**
     * Cache time to live for VO objects
     *
     * @var int
     */
    protected $cacheTtl = 600;

    /**
     * Primary key column name
     *
     * @var string
     */
    protected $primary;

    /**
     * Table name
     *
     * @var string
     */
    protected $table;

    /**
     * Table metadata for speccing type & such
     *
     * @var array
     */
    protected $metadata;

    /**
     * VO Class for this gateway
     *
     * @var string
     */
    protected $voClass;

    /**
     * @var baxe_App_Abstract
     */
    protected $app;

    /**
     * @var PDO
     */
    protected $db;

    /**
     * cached result of getVOProperties
     *
     * @var array
     */
    protected $properties = array();


    /**
     * @param baxe_App_Abstract $app
     */
    public function __construct(baxe_App_Abstract $app) {
        $this->app = $app;
    }

    /**
     * @return PDO
     */
    public function getDb() {
        if (null === $this->db) {
            $this->db = $this->app->getDatabase();
        }
        return $this->db;
    }

    abstract public function getPrimaryKey();
    abstract public function getTableName();
    abstract public function getVoClass();

    /**
     * Return the default properties for the given vo
     *
     * @param baxe_DAO_VOAbstract $vo
     * @return array<property=>default>
     */
    public function getVOProperties(baxe_DAO_VOAbstract $vo) {
        if (!count($this->properties)) {
            $this->properties = get_class_vars(get_class($vo));
        }
        return $this->properties;
    }

    /**
     * Typecast the vo properties according to their metadata definition.
     *
     * @param baxe_DAO_VOAbstract $vo
     */
    public function typecastProperties(baxe_DAO_VOAbstract $vo) {
        foreach ($this->getVOProperties($vo) as $key => $default) {
            if (!isset($this->metadata[$key])) {
                continue;
            }
            switch ($this->metadata[$key]['type']) {
                case self::TYPE_BOOL:
                    $vo->{$key} = (bool)$vo->{$key};
                    break;

                case self::TYPE_FLOAT:
                    $vo->{$key} = (float)$vo->{$key};
                    break;

                case self::TYPE_INT:
                    $vo->{$key} = (int)$vo->{$key};
                    break;

                case self::TYPE_STRING:
                default:
                    $vo->{$key} = (string)$vo->{$key};
                    break;
            }
        }
    }

    /**
     * Create a new vo instance
     * @return baxe_DAO_VOAbstract
     */
    public function newVo() {
        $voClass = $this->getVoClass();
        return new $voClass;
    }

    /**
     * Load a vo by its primary key
     *
     * @param mixed $id Record id
     * @param bool $useCached
     * @return baxe_DAO_VOAbstract
     * @throws Exception
     */
    public function load($id, $useCached=true) {
        try {
            $cached = $this->getCached($id);
            if (false !== $cached) {
                return $cached;
            }
        } catch (Exception $e) {}


        $vo = $this->newVo();
        $stmt = new baxe_DAO_Statement_Load($this->app, $this);
        $stmt->setId($id);
        $stmt->execute($vo);

        $this->setCached($vo);
        return $vo;
    }


    /**
     * Load a vo by id or create a blank one if unable to load.
     *
     * @param int $id
     * @return baxe_DAO_VOAbstract
     */
    public function loadOrCreate($id) {
        if ($id > 0) {
            try {
                $vo = $this->load($id);
            } catch (Exception $e) {}
        }

        if (!isset($vo)) {
            $vo = $this->newVo();
        }

        return $vo;
    }


    /**
     * Get the cached objects key [for accessing memcached or apc]
     *
     * @param int $id
     * @return string
     */
    protected function getCacheKey($id) {
        return $this->getVoClass() .".". $id;
    }


    /**
     * Attempt to load a vo based on the id passed.  If it is unable to load the
     * vo it will just return the supplied vo.
     *
     * @param int $id
     * @return baxe_DAO_VOAbstract
     */
    protected function getCached($id) {
        if ($attempt = apc_fetch($this->getCacheKey($id))) {
            return $attempt;
        }
        return false;
    }

    /**
     * Cache a vo
     *
     * @param baxe_DAO_VOAbstract $vo
     * @return void
     */
    protected function setCached(baxe_DAO_VOAbstract $vo) {
        $k = $this->getCacheKey($vo->getId());
        apc_delete($k); // this wasnt updating for some reason
        apc_store($k, $vo, $this->cacheTtl);
    }

    /**
     * Saves a vo by using insert/update.
     *
     * @param baxe_DAO_VOAbstract $vo
     * @throws Exception
     */
    public function save(baxe_DAO_VOAbstract $vo) {
        if ($vo->getId()) {
            $this->update($vo);
        } else {
            $this->insert($vo);
        }
        $this->setCached($vo);
    }

    /**
     * Update an existing vo record
     *
     * @param baxe_DAO_VOAbstract $vo
     * @throws Exception
     */
    public function update(baxe_DAO_VOAbstract $vo) {
        $stmt = new baxe_DAO_Statement_Update($this->app, $this);
        $stmt->execute($vo);
    }

    /**
     * Insert a new vo record
     *
     * @param baxe_DAO_VOAbstract $vo
     * @throws Exception
     */
    public function insert(baxe_DAO_VOAbstract $vo) {
        $stmt = new baxe_DAO_Statement_Insert($this->app, $this);
        $stmt->execute($vo);
    }

    /**
     * Delete a vo
     *
     * @param baxe_DAO_VOAbstract $vo
     * @throws Exception
     */
    public function delete(baxe_DAO_VOAbstract $vo) {
        $stmt = new baxe_DAO_Statement_Delete($this->app, $this);
        $stmt->execute($vo);
    }


    /**
     * Load a VO by an array of data
     *
     * @param baxe_DAO_VOAbstract $vo
     * @param array $data
     */
    public function loadByArray(baxe_DAO_VOAbstract $vo, array $data) {
        $vo->published = 0;
        $vo->allowComments = 0;
        $props = get_object_vars($vo);
        $match = array_intersect(array_keys($props), array_keys($data));
        foreach ($match as $prop) {
            $vo->{$prop} = $data[$prop];
        }
    }


}
