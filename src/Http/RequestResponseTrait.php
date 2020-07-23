<?php
/**
 * Created by PhpStorm.
 * User: cameron
 * Date: 23/07/20
 * Time: 21:18
 */

namespace CameronSmith\GAEManagerAPI\Http;

use Slim\Http\Response;

trait RequestResponseTrait
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