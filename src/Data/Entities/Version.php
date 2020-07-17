<?php namespace UKCASmith\GAEManagerAPI\Data\Entities;

class Version extends Entity
{
    /**
     * @var string.
     */
    protected $str_version_id;

    /**
     * Get array.
     *
     * @return array
     */
    public function getArray() {
        return [
            'key_id' => $this->getKeyId(),
            'version_id' => $this->getVersionId(),
        ];
    }

    /**
     * Set version ID.
     *
     * @param $str_version_id
     * @return $this
     */
    public function setVersionId($str_version_id) {
        $this->str_version_id = $str_version_id;
        return $this;
    }

    /**
     * Get version ID.
     *
     * @return string
     */
    public function getVersionId() {
        return $this->str_version_id;
    }

    /**
     * Build from google entity record.
     *
     * @param $arr_record
     * @return $this
     */
    public function buildFromArray($arr_record)
    {
        $this
            ->setKey($arr_record['key'])
            ->setKeyId($arr_record['key_id'])
            ->setVersionId($arr_record['version_id']);

        return $this;
    }
}