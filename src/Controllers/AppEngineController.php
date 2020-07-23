<?php namespace UKCASmith\GAEManagerAPI\Controllers;

use UKCASmith\GAEManagerAPI\Helpers\HttpCodes;

class AppEngineController extends Controller
{
    /**
     * Deploy an app-engine version to GAE.
     *
     * @route POST /app-engine/deploy
     * @return string
     */
    public function deploy() {
        return $this->respond(HttpCodes::HTTP_OK, []);
    }
}