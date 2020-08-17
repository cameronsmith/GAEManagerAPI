<?php namespace CameronSmith\GAEManagerAPI\Controllers;

use CameronSmith\GAEManagerAPI\Helpers\HttpCodes;

class PingController extends Controller
{
    /**
     * @return string
     */
    public function ping() {
        return $this->respond(HttpCodes::HTTP_OK, [
            'pong'
        ]);
    }
}