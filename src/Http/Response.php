<?php namespace CameronSmith\GAEManagerAPI\Http;

use CameronSmith\GAEManagerAPI\Exceptions\HeadersAlreadySent;
use Slim\Http\Response as SlimResponse;
use CameronSmith\GAEManagerAPI\Helpers\HttpCodes;

class Response extends SlimResponse
{
    /**
     * @var array
     */
    protected $arr_headers = [];

    /**
     * @var int
     */
    protected $int_status_code = HttpCodes::HTTP_OK;

    /**
     * @var string
     */
    protected $str_body;

    /**
     * Set headers.
     *
     * @param array $arr_headers
     * @return $this
     */
    public function setHeaders(array $arr_headers) {
        $this->arr_headers = array_merge($this->arr_headers, $arr_headers);
        return $this;
    }

    /**
     * Get headers.
     *
     * @return array
     */
    public function getHeaders() {
        return $this->arr_headers;
    }

    /**
     * Set status code.
     *
     * @param int $int_status_code
     * @return $this
     */
    public function setStatusCode($int_status_code) {
        $this->int_status_code = $int_status_code;
        return $this;
    }

    /**
     * Get status code.
     *
     * @return int
     */
    public function getStatusCode() {
        return $this->int_status_code;
    }

    /**
     * Set body.
     *
     * @param string $str_body
     * @return $this
     */
    public function setBody($str_body) {
        $this->str_body = $str_body;
        return $this;
    }

    /**
     * Get body.
     *
     * @return string
     */
    public function getBody() {
        return $this->str_body;
    }

    /**
     * Get JSON body as array.
     *
     * @return array|null
     */
    public function getJsonBodyAsArray() {
        return json_decode($this->getBody(), true);
    }

    /**
     * Get output from response.
     *
     * @return string
     * @throws HeadersAlreadySent
     */
    public function getOutput() {
        if (headers_sent()) {
            throw new HeadersAlreadySent('Cannot generate output headers have already been sent');
        }

        $arr_headers = $this->getHeaders();
        if (!empty($arr_headers)) {
            foreach($arr_headers as $str_header) {
                header($str_header);
            }
        }

        http_response_code($this->getStatusCode());
        return $this->getBody();
    }
}