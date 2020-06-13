<?php namespace UKCASmith\GAEManagerAPI;

use FastRoute\Dispatcher;
use Auryn\Injector;

class Application
{
    /**
     * @var Injector
     */
    protected $obj_injector;

    /**
     * @var Dispatcher
     */
    protected $obj_routes;

    /**
     * Application constructor.
     *
     * @param Injector $obj_injector
     */
    public function __construct(Injector $obj_injector)
    {
        $this->obj_injector = $obj_injector;
        $this->registerProviders(Providers::APP);
    }

    /**
     * Add routes to application.
     *
     * @param Dispatcher $obj_routes
     * @return $this
     */
    public function addRoutes(Dispatcher $obj_routes) {
        $this->obj_routes = $obj_routes;
        return $this;
    }

    /**
     * Run through application routes.
     */
    public function run() {
        $obj_request = $this->obj_injector->make('Psr\Http\Message\ServerRequestInterface');
        $arr_route = $this->obj_routes->dispatch($obj_request->getMethod(), $obj_request->getUri()->getPath());

        switch ($arr_route[0]) {
            case Dispatcher::FOUND:
                $str_class = $arr_route[1][0];
                $str_method = $arr_route[1][1];
                $arr_vars = (isset($arr_route[2]) ? $arr_route[2] : []);
                $obj_request
                    ->setQueryParams($arr_vars)
                    ->setRequestClass($str_class)
                    ->setRequestClassMethod($str_method);

                $obj_controller = $this->obj_injector->make($str_class);
                return $obj_controller->$str_method();
                break;
            default:
                http_response_code(404);
                break;
        }
    }

    /**
     * Register an interface with a class.
     *
     * @param $obj_interface
     * @param $obj_class
     * @return $this
     */
    public function addInterfaceAlias($obj_interface, $obj_class) {
        $this->obj_injector->alias($obj_interface, $obj_class);
        return $this;
    }

    /**
     * Bind a singleton or overwrite singleton.
     *
     * @param $instance
     */
    public function bindSingleton($instance) {
        $this->obj_injector->share($instance);
    }

    /**
     * Register application providers with the injector.
     *
     * @param array $providers
     */
    protected function registerProviders(array $providers) {
        foreach($providers as $interface => $class) {
            $this->addInterfaceAlias($interface, $class);
        }
    }

}