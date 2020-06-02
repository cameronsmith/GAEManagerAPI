<?php namespace UKCASmith\GAEManagerAPI\Controllers;

use Google\Cloud\Datastore\DatastoreClient;
use Google\Cloud\Datastore\Entity;
use Google\Cloud\Datastore\Query\Query;

class VersionsController extends Controller
{
    /**
     * Create a version.
     */
    public function create() {
        $arr_request = $this->getRequest()->getBody()->getContents();

        $datastore = new DatastoreClient();

        $query = $datastore->query()
            ->kind('Person');

        $result = $datastore->runQuery($query);
        /** @var Entity $item */
        foreach($result as $item) {
            print_r($item->get());
        }


        exit();

        // Create an entity
        $bob = $datastore->entity('Person');
        $bob['firstName'] = 'Bob';
        $bob['email'] = 'bob@example.com';
        $datastore->insert($bob);

        return $this->respond([
            'working'
        ]);
    }
}