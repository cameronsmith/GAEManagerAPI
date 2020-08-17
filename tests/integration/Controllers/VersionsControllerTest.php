<?php

class VersionsControllerTest extends BaseTest
{
    const ENDPOINT_VERSIONS = '/versions';

    public function test_we_can_create_a_version() {
        $obj_post = new stdClass;
        $obj_post->version_id = '12345';
        $arr_response = $this->post(self::ENDPOINT_VERSIONS, $obj_post);
        $this->assertArrayHasKey('key_id', $arr_response);
        $this->assertArrayHasKey('version_id', $arr_response);
        $this->assertEquals($arr_response['version_id'], $obj_post->version_id);
    }
}