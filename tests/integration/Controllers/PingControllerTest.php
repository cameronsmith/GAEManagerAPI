<?php

class PingControllerTest extends BaseTest
{
    const ENDPOINT_PING = '/ping';

    public function test_we_can_ping_endpoint() {
        $arr_response = $this->get(self::ENDPOINT_PING, []);
        $arr_expected = [
            'pong',
        ];
        $this->assertEquals($arr_expected, $arr_response);
    }
}