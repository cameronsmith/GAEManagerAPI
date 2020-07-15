<?php namespace UKCASmith\GAEManagerAPI\Data\Entities;

use Google\Cloud\Datastore\DatastoreClient;
use Google\Cloud\Datastore\Key;
use Google\Cloud\Datastore\Entity as GoogleEntity;

abstract class Entity
{
    /**
     * @var string
     */
    protected $str_key_id;

    /**
     * @var Key
     */
    protected $obj_key;

    /**
     * Set key ID.
     *
     * @param $str_key_id
     * @return $this
     */
    public function setKeyId($str_key_id) {
        $this->str_key_id = $str_key_id;
        return $this;
    }

    /**
     * Get key ID.
     *
     * @return string
     */
    public function getKeyId() {
        return $this->str_key_id;
    }

    /**
     * Set key.
     *
     * @param Key $obj_key
     * @return $this
     */
    public function setKey(Key $obj_key) {
        $this->obj_key = $obj_key;
        return $this;
    }

    /**
     * Get key.
     *
     * @return Key
     */
    public function getKey() {
        return $this->obj_key;
    }

    abstract public function getEntityName();
    abstract public function getEntityFields();
    abstract public function build(GoogleEntity $obj_record);
}