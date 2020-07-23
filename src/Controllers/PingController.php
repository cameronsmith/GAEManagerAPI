<?php namespace CameronSmith\GAEManagerAPI\Controllers;

class PingController extends Controller
{
    /**
     * @return string
     */
    public function ping() {
        return $this->respond([
            'pong'
        ]);
    }
}