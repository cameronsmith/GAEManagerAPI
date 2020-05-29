<?php namespace UKCASmith\GAEManagerAPI\Controllers;

class PingController extends Controller
{
    /**
     * @return \Psr\Http\Message\StreamInterface
     */
    public function ping() {
        return $this->respond([
            'pong'
        ]);
    }
}