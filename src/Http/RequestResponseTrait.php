<?php
/**
 * Created by PhpStorm.
 * User: cameron
 * Date: 23/07/20
 * Time: 21:18
 */

namespace CameronSmith\GAEManagerAPI\Http;

trait RequestResponseTrait
{
    /**
     * @var Request
     */
    private $obj_request;

    /**
     * @var Response
     */
    private $obj_response;

    /**
     * Set request object.
     *
     * @param Request $obj_request
     * @return $this
     */
    public function setRequest(Request $obj_request) {
        $this->obj_request = $obj_request;
        return $this;
    }

    /**
     * Get request.
     *
     * @return Request
     */
    public function getRequest()
    {
        return $this->obj_request;
    }

    /**
     * Set response object.
     *
     * @param Response $obj_response
     * @return $this
     */
    public function setResponse(Response $obj_response) {
        $this->obj_response = $obj_response;
        return $this;
    }

    /**
     * Get request.
     *
     * @return Response
     */
    public function getResponse()
    {
        return $this->obj_response;
    }
}