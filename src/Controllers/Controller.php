<?php namespace CameronSmith\GAEManagerAPI\Controllers;

use CameronSmith\GAEManagerAPI\Http\RequestResponseAwareInterface;
use CameronSmith\GAEManagerAPI\Http\RequestResponseTrait;
use CameronSmith\GAEManagerAPI\Helpers\HttpCodes;
use JsonSchema\Validator as JsonValidator;

class Controller implements RequestResponseAwareInterface
{
    use RequestResponseTrait;

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

        return $this->respond(HttpCodes::HTTP_BAD_REQUEST, $arr_response);
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