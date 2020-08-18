<?php namespace CameronSmith\GAEManagerAPI\Test;

use CameronSmith\GAEManagerAPI\Application;
use CameronSmith\GAEManagerAPI\Http\Response;
use PHPUnit\Framework\TestCase;
use CameronSmith\GAEManagerAPI\Http\Request;
use CameronSmith\GAEManagerAPI\Test\Stubs\PHPStream;

abstract class BaseTest extends TestCase
{
    use CreateApplication;

    /**
     * HTTP Methods
     */
    const POST = 'POST';
    const PUT = 'PUT';
    const GET = 'GET';
    const DELETE = 'DELETE';

    /**
     * @var Application
     */
    protected $obj_app;

    /**
     * Setup test application.
     */
    public function setUp() {
        parent::setUp();
        $this->clearRepository();
        $this->obj_app = $this->getAppInstance();
    }

    /**
     * Make a get request to the application.
     *
     * @param string $str_url
     * @param array $arr_body
     * @param array $arr_headers
     * @return Response
     */
    protected function get($str_url, $arr_body, $arr_headers = []) {
        $str_url .= $this->arrayToUrlRequest($arr_body);
        $this->createRequest(self::GET, [], $str_url, $arr_headers);
        return $this->obj_app->run();
    }

    /**
     * Make a post request to the application.
     *
     * @param string $str_url
     * @param array $arr_body
     * @param array $arr_headers
     * @return Response
     */
    public function post($str_url, $arr_body = [], $arr_headers = []) {
        $this->createRequest(self::POST, $arr_body, $str_url, $arr_headers);
        return $this->obj_app->run();
    }

    /**
     * Make a put request to the application.
     *
     * @param string $str_url
     * @param array $arr_body
     * @param array $arr_headers
     * @return Response
     */
    public function put($str_url, $arr_body = [], $arr_headers = []) {
        $this->createRequest(self::PUT, $arr_body, $str_url, $arr_headers);
        return $this->obj_app->run();
    }

    /**
     * Make a put request to the application.
     *
     * @param string $str_url
     * @param array $arr_headers
     * @return Response
     */
    public function delete($str_url, $arr_headers = []) {
        $this->createRequest(self::DELETE, [], $str_url, $arr_headers);
        return $this->obj_app->run();
    }

    /**
     * Phrase an array to a url request.
     *
     * @param array $arr_array
     * @return string
     */
    protected function arrayToUrlRequest(array $arr_array) {
        $arr_request_variables = [];
        foreach($arr_array as $str_key => $str_value) {
            $arr_request_variables[] = "$str_key=$str_value";
        }

        return '?' . implode('&', $arr_request_variables);
    }

    /**
     * Create a request.
     *
     * This will override the original request held in the app.
     *
     * @param string $str_method
     * @param array $arr_body
     * @param string $str_url
     * @param array $arr_headers
     */
    protected function createRequest($str_method, $arr_body, $str_url, $arr_headers = []) {
        $request = [
            'REQUEST_METHOD' => $str_method,
            'REQUEST_URI' => $str_url,
            'HTTP_CONTENT_TYPE' => (count($arr_headers) > 0 ? $arr_headers : 'application/json')
        ];

        $this->attachRequestToSingleton($request, $arr_body);
    }

    /**
     * Attach a request to the app singleton method.
     *
     * @param $request
     * @param $body
     */
    protected function attachRequestToSingleton($request, $body) {
        $this->mockPhpStream();
        file_put_contents('php://input', json_encode($body));
        $this->obj_app->bindSingleton(Request::createFromGlobals($request));
        $this->unmockPhpStream();
    }

    /**
     * Mock php streams.
     */
    protected function mockPhpStream() {
        stream_wrapper_unregister("php");
        stream_wrapper_register("php", PHPStream::class);
    }

    /**
     * Re-register original PHP streams.
     */
    protected function unmockPhpStream() {
        stream_wrapper_restore("php");
    }

    /**
     * Make object from Dependency Injector.
     *
     * Note: This would normally be an anti-pattern but because we are within tests...it's okay...maybe?
     *
     * @param string $str_class_name
     * @return mixed
     */
    protected function injectorMake($str_class_name) {
        return $this->obj_app->getInjector()->make($str_class_name);
    }
}