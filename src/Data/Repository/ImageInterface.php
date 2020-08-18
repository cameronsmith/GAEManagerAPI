<?php namespace CameronSmith\GAEManagerAPI\Data\Repository;

use CameronSmith\GAEManagerAPI\Data\Entities\Entity;

interface ImageInterface extends BaseInterface
{
    /**
     * Get by bucket and filename.
     *
     * @param string $str_bucket
     * @param string $str_filename
     * @return Entity|null
     */
    public function getByBucketAndFilename($str_bucket, $str_filename);
}