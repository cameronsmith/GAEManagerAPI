<?php namespace UKCASmith\GAEManagerAPI\Http;

use Slim\Http\Request as SlimRequest;

class Request extends SlimRequest
{
    const CONTROLLER_NAMESPACE = 'UKCASmith\\GAEManagerAPI\\Controllers\\';

    /**
     * @var string
     */
    protected $str_request_class_method;

    /**
     * @var string
     */
    protected $str_request_class;

    /**
     * Set request class method.
     *
     * @param $str_method
     * @return $this
     */
    public function setRequestClassMethod($str_method) {
        $this->str_request_class_method = $str_method;
        return $this;
    }

    /**
     * Get request class method.
     *
     * @return string
     */
    public function getRequestClassMethod() {
        return $this->str_request_class_method;
    }

    /**
     * Set request class method.
     *
     * @param $str_class
     * @return $this
     */
    public function setRequestClass($str_class) {
        $arr_path = explode('\\', str_ireplace(static::CONTROLLER_NAMESPACE, '', $str_class));
        $str_class_name = array_pop($arr_path);
        $str_class_name = str_ireplace('controller', '', $str_class_name);
        $arr_path[] = $str_class_name;
        $this->str_request_class = implode('\\', $arr_path);
        return $this;
    }

    /**
     * Get request class.
     *
     * @return string
     */
    public function getRequestClass() {
        return $this->str_request_class;
    }

    /**
     * Set query params.
     *
     * @param $arr_vars
     * @return $this
     */
    public function setQueryParams($arr_vars) {
        $this->queryParams = $arr_vars;
        return $this;
    }
}