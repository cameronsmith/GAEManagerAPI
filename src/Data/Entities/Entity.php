<?php namespace CameronSmith\GAEManagerAPI\Data\Entities;

use Google\Cloud\Datastore\Key;

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

    /**
     * Get array of entity keys + values.
     *
     * @return array
     */
    abstract public function getArray();

    /**
     * Populate from google entity record.
     *
     * @param $arr_record
     * @return $this
     */
    abstract public function buildFromArray($arr_record);
}