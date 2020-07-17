<?php namespace UKCASmith\GAEManagerAPI\Data\Repository\Datastore;

use Google\Cloud\Datastore\DatastoreClient;
use UKCASmith\GAEManagerAPI\Data\Entities\Version as VersionEntity;
use Google\Cloud\Datastore\EntityInterface as GoogleEntity;

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
     * Get all records.
     *
     * @return array
     */
    public function getAll() {
        $obj_query = $this->obj_client->query()->kind(static::KIND);

        $obj_result = $this->obj_client->runQuery($obj_query);

        if (iterator_count($obj_result) === 0) {
            return [];
        }

        $obj_result->rewind();
        $arr_entities = [];
        foreach($obj_result as $obj_record) {
            $arr_record = $this->getArrayFromGoogleEntity($obj_record);
            $arr_entities[] = (new VersionEntity)->buildFromArray($arr_record);
        }
        return $arr_entities;
    }

    /**
     * Insert.
     *
     * @param VersionEntity $obj_entity
     * @return VersionEntity
     */
    public function insert(VersionEntity $obj_entity) {
        $obj_repo_entity = $this->obj_client->entity(static::KIND);
        foreach($obj_entity->getArray() as $str_key => $mix_value) {
            $obj_repo_entity[$str_key] = $mix_value;
        }

        $this->obj_client->insert($obj_repo_entity);
        $arr_record = $this->getArrayFromGoogleEntity($obj_repo_entity);
        return (new VersionEntity)->buildFromArray($arr_record);
    }

    /**
     * Update.
     *
     * @param VersionEntity $obj_entity
     * @return VersionEntity
     */
    public function update(VersionEntity $obj_entity) {
        $obj_key = $this->obj_client->key(static::KIND, $obj_entity->getKeyId());
        $obj_repo_entity = $this->obj_client->lookup($obj_key);
        foreach($obj_entity->getArray() as $str_key => $mix_value) {
            $obj_repo_entity[$str_key] = $mix_value;
        }

        $this->obj_client->update($obj_repo_entity);
        $arr_record = $this->getArrayFromGoogleEntity($obj_repo_entity);
        return (new VersionEntity)->buildFromArray($arr_record);
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
        $arr_record = $this->getArrayFromGoogleEntity($obj_record);
        return (new VersionEntity)->buildFromArray($arr_record);
    }

    /**
     * Delete an entity.
     *
     * @param $str_key
     */
    public function delete($str_key) {
        $this->obj_client->delete($str_key);
    }

    /**
     * Get an array from the google entity record.
     *
     * @param GoogleEntity $obj_record
     * @return array
     */
    protected function getArrayFromGoogleEntity(GoogleEntity $obj_record) {
        $arr_record = [];
        $obj_key = $obj_record->key();
        $arr_record['key'] = $obj_key;
        $arr_record['key_id'] = $obj_key->pathEndIdentifier();

        foreach($obj_record->get() as $str_key => $mix_value) {
            if ($str_key === 'key' || $str_key === 'key_id') {
                continue;
            }
            $arr_record[$str_key] = $mix_value;
        }

        return $arr_record;
    }
}