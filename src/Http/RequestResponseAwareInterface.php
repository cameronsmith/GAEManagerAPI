<?php
/**
 * Created by PhpStorm.
 * User: cameron
 * Date: 23/07/20
 * Time: 21:15
 */

namespace UKCASmith\GAEManagerAPI\Http;

use Slim\Http\Response;

interface RequestResponseAwareInterface
{
    /**
     * Set request object.
     *
     * @param Request $obj_request
     * @return $this
     */
    public function setRequest(Request $obj_request);

    /**
     * Get request.
     *
     * @return Request
     */
    public function getRequest();

    /**
     * Set response object.
     *
     * @param Response $obj_response
     * @return $this
     */
    public function setResponse(Response $obj_response);

    /**
     * Get response.
     *
     * @return Response
     */
    public function getResponse();
}