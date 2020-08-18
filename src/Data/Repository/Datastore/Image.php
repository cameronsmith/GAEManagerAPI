<?php namespace CameronSmith\GAEManagerAPI\Data\Repository\Datastore;

use CameronSmith\GAEManagerAPI\Data\Entities\Image as ImageEntity;
use CameronSmith\GAEManagerAPI\Data\Entities\Entity;
use CameronSmith\GAEManagerAPI\Data\Repository\ImageInterface;

class Image extends Datastore implements ImageInterface
{
    const KIND = 'images';

    /**
     * Get by bucket and filename.
     *
     * @param string $str_bucket
     * @param string $str_filename
     * @return Entity|null
     */
    public function getByBucketAndFilename($str_bucket, $str_filename) {
        $obj_client = $this->getDatastoreClient();
        $obj_query = $obj_client->query()
            ->kind($this->getKind())
            ->filter('bucket', '=', trim($str_bucket))
            ->filter('filename', '=', trim($str_filename));

        return $this->getBy($obj_query);
    }

    /**
     * Get new entity.
     *
     * @return string
     */
    protected function getKind() {
        return static::KIND;
    }

    /**
     * Get new entity.
     *
     * @return Entity
     */
    protected function getNewEntity()
    {
        return new ImageEntity;
    }
}