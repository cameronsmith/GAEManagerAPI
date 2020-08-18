<?php namespace CameronSmith\GAEManagerAPI\Data\Repository;

use CameronSmith\GAEManagerAPI\Data\Entities\Entity;
use Google\Cloud\Datastore\Query\QueryInterface;

interface BaseInterface
{
    /**
     * Get by Key ID.
     *
     * @param string $str_key_id
     * @return Entity
     */
    public function getByKeyId($str_key_id);

    /**
     * Get all records.
     *
     * @return array
     */
    public function getAll();

    /**
     * Insert.
     *
     * @param Entity $obj_entity
     * @return Entity
     */
    public function insert(Entity $obj_entity);

    /**
     * Update.
     *
     * @param Entity $obj_entity
     * @return Entity
     */
    public function update(Entity $obj_entity);

    /**
     * Delete an entity.
     *
     * @param $str_key
     */
    public function delete($str_key);

    /**
     * Get by query.
     *
     * @param QueryInterface $obj_query
     * @return Entity|null
     */
    public function getBy(QueryInterface $obj_query);
}