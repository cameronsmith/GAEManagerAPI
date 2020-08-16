<?php namespace CameronSmith\GAEManagerAPI\Data\Entities;

class Image extends Entity
{
    /**
     * @var string.
     */
    protected $str_bucket;

    /**
     * @var string.
     */
    protected $str_filename;

    /**
     * Set bucket.
     *
     * @param $str_bucket
     * @return $this
     */
    public function setBucket($str_bucket) {
        $this->str_bucket = trim($str_bucket);
        return $this;
    }

    /**
     * Get bucket.
     *
     * @return string
     */
    public function getBucket() {
        return $this->str_bucket;
    }

    /**
     * Set filename.
     *
     * @param $str_filename
     * @return $this
     */
    public function setFilename($str_filename) {
        $this->str_filename = trim($str_filename);
        return $this;
    }

    /**
     * Get filename.
     *
     * @return string
     */
    public function getFilename() {
        return $this->str_filename;
    }

    /**
     * Get array.
     *
     * @return array
     */
    public function getArray() {
        $arr_parent_array = parent::getArray();

        return array_merge([
            'key_id' => $this->getKeyId(),
            'bucket' => $this->getBucket(),
            'filename' =>  $this->getFilename(),
        ], $arr_parent_array);
    }

    /**
     * Build from google entity record.
     *
     * @param $arr_record
     * @return $this
     */
    public function buildFromArray($arr_record)
    {
        parent::buildFromArray($arr_record);

        $this
            ->setKey($arr_record['key'])
            ->setKeyId($arr_record['key_id'])
            ->setBucket($arr_record['bucket'])
            ->setFilename($arr_record['filename']);

        return $this;
    }
}