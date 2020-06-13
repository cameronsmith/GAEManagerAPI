<?php namespace UKCASmith\GAEManagerAPI\Data\Repository\Datastore;

use Google\Cloud\Datastore\DatastoreClient;
use UKCASmith\GAEManagerAPI\Data\Entities\Version as VersionEntity;

class Version
{
    const KIND = 'version';

    /**
     * @var DatastoreClient
     */
    protected $obj_client;

    /**
     * Entity constructor.
     *
     * @param DatastoreClient $obj_client
     */
    public function __construct(DatastoreClient $obj_client) {
        $this->obj_client = $obj_client;
    }

    /**
     * Insert.
     *
     * @param VersionEntity $obj_entity
     * @return string
     */
    public function insert(VersionEntity $obj_entity) {
        $obj_repo_entity = $this->obj_client->entity(static::KIND);
        foreach($obj_entity->getEntityFields($obj_repo_entity) as $str_key => $mix_value) {
            $obj_repo_entity[$str_key] = $mix_value;
        }

        return $this->obj_client->insert($obj_repo_entity);
    }

    /**
     * Get by version ID.
     *
     * @param $str_version_id
     * @return VersionEntity|null
     */
    public function getByVersionId($str_version_id) {
        $obj_query = $this->obj_client->query()
            ->kind('version')
            ->filter('version_id', '=', $str_version_id);

        $obj_result = $this->obj_client->runQuery($obj_query);

        if (iterator_count($obj_result) === 0) {
            return null;
        }

        $obj_result->rewind();
        $obj_record = $obj_result->current();
        $obj_key = $obj_record->key();
        $obj_entity = new VersionEntity;
        $obj_entity
            ->setKey($obj_key)
            ->setKeyId($obj_key->pathEndIdentifier())
            ->setVersionId($obj_record->version_id);

        return $obj_entity;
    }

    /**
     * Delete an entity.
     *
     * @param $str_key
     */
    public function delete($str_key) {
        $this->obj_client->delete($str_key);
    }
}