<?php namespace CameronSmith\GAEManagerAPI\Test\Integration\Controllers;

use CameronSmith\GAEManagerAPI\Data\Entities\Version;
use CameronSmith\GAEManagerAPI\Data\Repository\VersionInterface;
use CameronSmith\GAEManagerAPI\Helpers\ErrorCodes;
use CameronSmith\GAEManagerAPI\Helpers\HttpCodes;
use stdClass;
use CameronSmith\GAEManagerAPI\Test\BaseTest;
use CameronSmith\GAEManagerAPI\Test\Factories\Version as VersionFactory;

class VersionsControllerTest extends BaseTest
{
    const ENDPOINT_VERSIONS = '/versions';

    public function test_we_can_create_a_version() {
        $obj_post = new stdClass;
        $obj_post->version_id = '12345';
        $obj_response = $this->post(self::ENDPOINT_VERSIONS, $obj_post);
        $arr_response = $obj_response->getJsonBodyAsArray();
        /** @var Version $obj_entity */
        $obj_entity = $this->injectorMake(VersionInterface::class)->getByVersionId('12345');

        $this->assertEquals(HttpCodes::HTTP_CREATED, $obj_response->getStatusCode());
        $this->assertArrayHasKey('key_id', $arr_response);
        $this->assertArrayHasKey('version_id', $arr_response);
        $this->assertEquals($obj_post->version_id, $arr_response['version_id']);
        $this->assertEquals($obj_entity->getVersionId(), $arr_response['version_id']);
    }

    public function test_we_cannot_create_duplicate_versions() {
        $this->injectorMake(VersionFactory::class)->make('12345');

        $obj_post = new stdClass;
        $obj_post->version_id = '12345';
        $obj_response = $this->post(self::ENDPOINT_VERSIONS, $obj_post);
        $arr_response = $obj_response->getJsonBodyAsArray();

        $this->assertEquals(HttpCodes::HTTP_BAD_REQUEST, $obj_response->getStatusCode());
        $this->assertArrayHasKey('error', $arr_response);
        $this->assertArrayHasKey('code', $arr_response);
        $this->assertEquals(ErrorCodes::DUPLICATE, $arr_response['code']);
    }

    public function test_we_can_update_a_version() {
        $this->injectorMake(VersionFactory::class)->make('12345');
        $obj_post = new stdClass;
        $obj_post->version_id = '67890';
        $obj_response = $this->put(self::ENDPOINT_VERSIONS . '/12345', $obj_post);
        $arr_response = $obj_response->getJsonBodyAsArray();

        $this->assertEquals(HttpCodes::HTTP_ACCEPTED, $obj_response->getStatusCode());
        $this->assertArrayHasKey('version_id', $arr_response);
        $this->assertEquals($obj_post->version_id, $arr_response['version_id']);
    }

    public function test_we_cannot_update_a_non_existing_version() {
        $obj_post = new stdClass;
        $obj_post->version_id = '67890';
        $obj_response = $this->put(self::ENDPOINT_VERSIONS . '/12345', $obj_post);
        $arr_response = $obj_response->getJsonBodyAsArray();

        $this->assertEquals(HttpCodes::HTTP_NOT_FOUND, $obj_response->getStatusCode());
        $this->assertArrayHasKey('error', $arr_response);
        $this->assertArrayHasKey('code', $arr_response);
        $this->assertEquals(ErrorCodes::NOT_FOUND, $arr_response['code']);
    }

    public function test_we_can_delete_a_version() {
        $this->injectorMake(VersionFactory::class)->make('12345');
        $obj_response = $this->delete(self::ENDPOINT_VERSIONS . '/12345');
        $mix_entity = $this->injectorMake(VersionInterface::class)->getByVersionId('12345');

        $this->assertEquals(HttpCodes::HTTP_NO_CONTENT, $obj_response->getStatusCode());
        $this->assertEquals(null, $mix_entity);
    }

    public function test_we_can_get_a_version() {
        $this->injectorMake(VersionFactory::class)->make('12345');
        $obj_response = $this->get(self::ENDPOINT_VERSIONS . '/12345', []);

        $this->assertEquals(HttpCodes::HTTP_OK, $obj_response->getStatusCode());
    }

    public function test_we_can_get_all_versions() {
        $obj_factory = $this->injectorMake(VersionFactory::class);
        $arr_versions = [
            1, 2, 3, 4, 5
        ];
        $obj_factory->make($arr_versions[0]);
        $obj_factory->make($arr_versions[1]);
        $obj_factory->make($arr_versions[2]);
        $obj_factory->make($arr_versions[3]);
        $obj_factory->make($arr_versions[4]);

        $obj_response = $this->get(self::ENDPOINT_VERSIONS, []);
        $arr_response = $obj_response->getJsonBodyAsArray();

        $this->assertEquals(HttpCodes::HTTP_OK, $obj_response->getStatusCode());
        $this->assertEquals(5, count($arr_response));
        $this->assertTrue(in_array($arr_response[0]['version_id'], $arr_versions));
        $this->assertTrue(in_array($arr_response[1]['version_id'], $arr_versions));
        $this->assertTrue(in_array($arr_response[2]['version_id'], $arr_versions));
        $this->assertTrue(in_array($arr_response[3]['version_id'], $arr_versions));
        $this->assertTrue(in_array($arr_response[4]['version_id'], $arr_versions));
    }
}