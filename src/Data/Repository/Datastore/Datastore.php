<?php namespace CameronSmith\GAEManagerAPI\Data\Repository\Datastore;

use CameronSmith\GAEManagerAPI\Data\Entities\Entity;
use CameronSmith\GAEManagerAPI\Services\Datastore\ClientAwareInterface;
use CameronSmith\GAEManagerAPI\Services\Datastore\ClientTrait;
use Google\Cloud\Datastore\EntityInterface as GoogleEntity;
use Google\Cloud\Datastore\Query\QueryInterface;

abstract class Datastore implements ClientAwareInterface
{
    use ClientTrait;

    /**
     * Get by Key ID.
     *
     * @param string $str_key_id
     * @return Entity
     */
    public function getByKeyId($str_key_id) {
        $obj_client = $this->getDatastoreClient();
        $obj_key = $obj_client->key($this->getKind(), $str_key_id);
        $obj_record = $obj_client->lookup($obj_key);

        if (empty($obj_record)) {
            return null;
        }

        $arr_record = $this->getArrayFromGoogleEntity($obj_record);
        return $this->getNewEntity()->buildFromArray($arr_record);
    }

    /**
     * Get all records.
     *
     * @return array
     */
    public function getAll() {
        $obj_client = $this->getDatastoreClient();
        $obj_query = $obj_client->query()->kind($this->getKind());

        $obj_result = $obj_client->runQuery($obj_query);

        if (iterator_count($obj_result) === 0) {
            return [];
        }

        $obj_result->rewind();
        $arr_entities = [];
        foreach($obj_result as $obj_record) {
            $arr_record = $this->getArrayFromGoogleEntity($obj_record);
            $arr_entities[] = ($this->getNewEntity())->buildFromArray($arr_record);
        }
        return $arr_entities;
    }

    /**
     * Insert.
     *
     * @param Entity $obj_entity
     * @return Entity
     */
    public function insert(Entity $obj_entity) {
        $obj_client = $this->getDatastoreClient();
        $obj_repo_entity = $obj_client->entity($this->getKind());

        if ($obj_entity->isCreatedAtPersisted() && empty($obj_entity->getCreatedAt())) {
            $obj_entity->setCreatedAt(new \DateTime);
        }

        foreach($obj_entity->getArray() as $str_key => $mix_value) {
            $obj_repo_entity[$str_key] = $mix_value;
        }



        $obj_client->insert($obj_repo_entity);
        $arr_record = $this->getArrayFromGoogleEntity($obj_repo_entity);
        return $this->getNewEntity()->buildFromArray($arr_record);
    }

    /**
     * Update.
     *
     * @param Entity $obj_entity
     * @return Entity
     */
    public function update(Entity $obj_entity) {
        $obj_client = $this->getDatastoreClient();
        $obj_key = $obj_client->key($this->getKind(), $obj_entity->getKeyId());
        $obj_repo_entity = $obj_client->lookup($obj_key);

        if ($obj_entity->isUpdatedAtPersisted()) {
            $obj_entity->setUpdatedAt(new \DateTime);
        }

        foreach($obj_entity->getArray() as $str_key => $mix_value) {
            $obj_repo_entity[$str_key] = $mix_value;
        }

        $obj_client->update($obj_repo_entity);
        $arr_record = $this->getArrayFromGoogleEntity($obj_repo_entity);
        return $this->getNewEntity()->buildFromArray($arr_record);
    }

    /**
     * Delete an entity.
     *
     * @param $str_key
     */
    public function delete($str_key) {
        $this->getDatastoreClient()->delete($str_key);
    }

    /**
     * Get by query.
     *
     * @param QueryInterface $obj_query
     * @return Entity|null
     */
    public function getBy(QueryInterface $obj_query) {
        $obj_client = $this->getDatastoreClient();
        $obj_result = $obj_client->runQuery($obj_query);

        if (iterator_count($obj_result) === 0) {
            return null;
        }

        $obj_result->rewind();
        $obj_record = $obj_result->current();
        $arr_record = $this->getArrayFromGoogleEntity($obj_record);
        return $this->getNewEntity()->buildFromArray($arr_record);
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

    /**
     * Get KIND name.
     *
     * @return string
     */
    abstract protected function getKind();

    /**
     * Get new entity.
     *
     * @return Entity
     */
    abstract protected function getNewEntity();
}