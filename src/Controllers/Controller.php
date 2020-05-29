<?php namespace UKCASmith\GAEManagerAPI\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use UKCASmith\GAEManagerAPI\Helpers\HttpCodes;

class Controller
{
    /**
     * @var Request
     */
    protected $obj_request;

    /**
     * @var Response
     */
    protected $obj_response;

    /**
     * PingController constructor.
     *
     * @param Request $request
     * @param Response $response
     */
    public function __construct(Request $request, Response $response)
    {
        $this->obj_request = $request;
        $this->obj_response = $response;
    }

    /**
     * Send JSON headers.
     *
     * @return bool
     */
    protected function sendJsonHeader() {
        if (headers_sent()) {
            return false;
        }

        header('pragma: no-cache');
        header('cache-control: no-store');
        header('content-type: application/json; charset=UTF-8');
    }

    /**
     * Return JSON OK response.
     *
     * @param array $response
     * @param int $httpCode
     * @return string
     */
    protected function respond(array $response, $httpCode = HttpCodes::HTTP_OK) {
        $this->sendHttpResponseCode($httpCode);
        $this->sendJsonHeader();
        return json_encode($response, JSON_PRETTY_PRINT);
    }

    /**
     * Send http response code
     *
     * @param $httpCode
     * @return bool|int
     */
    protected function sendHttpResponseCode($httpCode) {
        if (headers_sent()) {
            return false;
        }

        return http_response_code($httpCode);
    }

}