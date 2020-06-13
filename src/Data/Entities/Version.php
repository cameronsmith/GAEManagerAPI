<?php namespace UKCASmith\GAEManagerAPI\Data\Entities;

class Version extends Entity
{
    const ENTITY_NAME = 'version';

    protected $str_version_id;

    /**
     * @return string
     */
    public function getEntityName() {
        return static::ENTITY_NAME;
    }

    /**
     * @return array
     */
    public function getEntityFields() {
        return [
            'version_id' => $this->getVersionId(),
        ];
    }

    public function setVersionId($str_version_id) {
        $this->str_version_id = $str_version_id;
        return $this;
    }

    public function getVersionId() {
        return $this->str_version_id;
    }
}