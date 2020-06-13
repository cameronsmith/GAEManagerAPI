<?php namespace UKCASmith\GAEManagerAPI\Controllers;

use UKCASmith\GAEManagerAPI\Http\Request;
use Slim\Http\Response;
use UKCASmith\GAEManagerAPI\Helpers\HttpCodes;
use JsonSchema\Validator as JsonValidator;

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
    protected function sendJsonHeader()
    {
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
     * @param int $httpCode
     * @param array $arr_response
     * @return string
     */
    protected function respond($httpCode = HttpCodes::HTTP_OK, array $arr_response = null)
    {
        $this->sendHttpResponseCode($httpCode);
        $this->sendJsonHeader();
        if (is_null($arr_response)) {
            return null;
        }
        return json_encode($arr_response, JSON_PRETTY_PRINT);
    }

    /**
     * Send http response code
     *
     * @param $httpCode
     * @return bool|int
     */
    protected function sendHttpResponseCode($httpCode)
    {
        if (headers_sent()) {
            return false;
        }

        return http_response_code($httpCode);
    }

    /**
     * Respond invalid request.
     *
     * @param JsonValidator $obj_validator
     * @return string
     */
    protected function respondInvalidateRequest(JsonValidator $obj_validator)
    {
        $arr_response = [
            'error' => 'The request could not be completed because the request is invalid',
            'reasons' => [],
        ];

        foreach ($obj_validator->getErrors() as $arr_error) {
            $arr_response['reasons'][] = $arr_error['message'];
        }

        return $this->respond($arr_response, HttpCodes::HTTP_BAD_REQUEST);
    }

    /**
     * Get request.
     *
     * @return Request
     */
    protected function getRequest()
    {
        return $this->obj_request;
    }

    /**
     * Get JSON request body.
     *
     * @return \stdClass
     */
    protected function getJsonRequestBody() {
        $obj_request = $this->getRequest();
        $obj_request->getBody()->rewind();
        return $arr_data = json_decode($obj_request->getBody()->getContents());
    }

}