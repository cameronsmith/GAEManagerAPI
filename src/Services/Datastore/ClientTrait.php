<?php
/**
 * Created by PhpStorm.
 * User: cameron
 * Date: 23/07/20
 * Time: 21:18
 */

namespace CameronSmith\GAEManagerAPI\Services\Datastore;

use Google\Cloud\Datastore\DatastoreClient;

trait ClientTrait
{
    /**
     * @var DatastoreClient
     */
    private $obj_datastore_client;

    /**
     * Set request object.
     *
     * @param DatastoreClient $obj_client
     * @return $this
     */
    public function setDatastoreClient(DatastoreClient $obj_client) {
        $this->obj_datastore_client = $obj_client;
        return $this;
    }

    /**
     * Get request.
     *
     * @return DatastoreClient
     */
    public function getDatastoreClient()
    {
        return $this->obj_datastore_client;
    }
}