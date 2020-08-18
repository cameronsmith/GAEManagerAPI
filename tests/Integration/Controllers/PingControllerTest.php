<?php namespace CameronSmith\GAEManagerAPI\Test\Integration\Controllers;

use CameronSmith\GAEManagerAPI\Helpers\HttpCodes;
use CameronSmith\GAEManagerAPI\Test\BaseTest;

class PingControllerTest extends BaseTest
{
    const ENDPOINT_PING = '/ping';

    public function test_we_can_ping_endpoint() {
        $obj_response = $this->get(self::ENDPOINT_PING, []);
        $arr_response = $obj_response->getJsonBodyAsArray();
        $arr_expected = [
            'pong',
        ];

        $this->assertEquals(HttpCodes::HTTP_OK, $obj_response->getStatusCode());
        $this->assertEquals($arr_expected, $arr_response);
    }
}