<?php
/**
 * Created by PhpStorm.
 * User: cameron
 * Date: 23/07/20
 * Time: 21:15
 */

namespace CameronSmith\GAEManagerAPI\Services\Datastore;

use Google\Cloud\Datastore\DatastoreClient;

interface ClientAwareInterface
{
    /**
     * Set request object.
     *
     * @param DatastoreClient $obj_request
     * @return $this
     */
    public function setDatastoreClient(DatastoreClient $obj_request);

    /**
     * Get request.
     *
     * @return DatastoreClient
     */
    public function getDatastoreClient();
}