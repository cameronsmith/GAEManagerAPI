<?php namespace CameronSmith\GAEManagerAPI\Data\Entities;

use DateTimeInterface;
use Google\Cloud\Datastore\Key;

abstract class Entity
{
    /**
     * Allow the repo to automatically assign created_at + updated_at.
     */
    const USE_CREATED_AT = true;
    const USE_UPDATED_AT = true;

    /**
     * @var string
     */
    protected $str_key_id;

    /**
     * @var Key
     */
    protected $obj_key;

    /**
     * @var DateTimeInterface
     */
    protected $obj_created_at;

    /**
     * @var DateTimeInterface
     */
    protected $obj_updated_at;

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
     * Set created_at.
     *
     * @param DateTimeInterface|null $obj_created_at
     * @return $this
     */
    public function setCreatedAt($obj_created_at) {
        $this->obj_created_at = $obj_created_at;
        return $this;
    }

    /**
     * Get created_at.
     *
     * @return DateTimeInterface|null
     */
    public function getCreatedAt() {
        return $this->obj_created_at;
    }

    /**
     * Set created_at.
     *
     * @param DateTimeInterface|null $obj_updated_at|null
     * @return $this
     */
    public function setUpdatedAt($obj_updated_at) {
        $this->obj_updated_at = $obj_updated_at;
        return $this;
    }

    /**
     * Get updated_at.
     *
     * @return DateTimeInterface|null
     */
    public function getUpdatedAt() {
        return $this->obj_updated_at;
    }

    /**
     * Is the created_at field persisted.
     *
     * @return bool
     */
    public function isCreatedAtPersisted() {
        return static::USE_CREATED_AT;
    }

    /**
     * Is the updated_at field persisted.
     *
     * @return bool
     */
    public function isUpdatedAtPersisted() {
        return static::USE_UPDATED_AT;
    }

    /**
     * Get array.
     *
     * @return array
     */
    public function getArray() {
        $arr_array = [];

        if ($this->isCreatedAtPersisted()) {
            $arr_array['created_at'] = $this->getCreatedAt();
        }

        if ($this->isUpdatedAtPersisted()) {
            $arr_array['updated_at'] = $this->getUpdatedAt();
        }

        return $arr_array;
    }

    /**
     * Build from google entity record.
     *
     * @param $arr_record
     * @return $this
     */
    public function buildFromArray($arr_record)
    {
        if ($this->isCreatedAtPersisted()) {
            $this->setCreatedAt($arr_record['created_at']);
        }

        if ($this->isUpdatedAtPersisted()) {
            $this->setUpdatedAt($arr_record['updated_at']);
        }

        return $this;
    }
}