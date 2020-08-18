<?php namespace CameronSmith\GAEManagerAPI\Data\Repository;

use CameronSmith\GAEManagerAPI\Data\Entities\Entity;

interface VersionInterface extends BaseInterface {
    /**
     * Get by version ID.
     *
     * @param $str_version_id
     * @return Entity|null
     */
    public function getByVersionId($str_version_id);
}