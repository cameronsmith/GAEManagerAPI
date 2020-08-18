<?php namespace CameronSmith\GAEManagerAPI\Data\Repository\Datastore;

use CameronSmith\GAEManagerAPI\Data\Entities\Entity;
use CameronSmith\GAEManagerAPI\Data\Entities\Version as VersionEntity;
use CameronSmith\GAEManagerAPI\Data\Repository\VersionInterface;

class Version extends Datastore implements VersionInterface
{
    const KIND = 'versions';

    /**
     * Get by version ID.
     *
     * @param $str_version_id
     * @return Entity|null
     */
    public function getByVersionId($str_version_id) {
        $obj_client = $this->getDatastoreClient();
        $obj_query = $obj_client->query()
            ->kind($this->getKind())
            ->filter('version_id', '=', $str_version_id);

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
        return new VersionEntity;
    }
}