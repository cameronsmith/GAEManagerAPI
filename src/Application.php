<?php namespace CameronSmith\GAEManagerAPI;

use CameronSmith\GAEManagerAPI\Helpers\HttpCodes;
use CameronSmith\GAEManagerAPI\Http\Response;
use FastRoute\Dispatcher;
use Auryn\Injector;
use CameronSmith\GAEManagerAPI\Http\RequestResponseAwareInterface;
use CameronSmith\GAEManagerAPI\Services\Datastore\ClientAwareInterface;
use Google\Cloud\Datastore\DatastoreClient;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

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
     * Run application.
     *
     * @return Response
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
                $obj_response = $obj_controller->$str_method();
                break;
            default:
                $obj_response = $this->obj_injector->make('Psr\Http\Message\ResponseInterface');
                $obj_response->setHttpCode(HttpCodes::HTTP_NOT_FOUND);
                break;
        }

        return $obj_response;
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
     * @return $this
     */
    public function bindSingleton($instance) {
        $this->obj_injector->share($instance);
        return $this;
    }

    /**
     * Register setter injectors.
     */
    public function registerSetterInjectors() {
        $this->obj_injector
            ->prepare(
                RequestResponseAwareInterface::class,
                function(RequestResponseAwareInterface $obj_needs_item, Injector $obj_di) {
                    $obj_needs_item->setRequest($obj_di->make(ServerRequestInterface::class));
                    $obj_needs_item->setResponse($obj_di->make(ResponseInterface::class));
                }
            );

        $this->obj_injector
            ->prepare(
                ClientAwareInterface::class,
                function(ClientAwareInterface $obj_needs_item, Injector $obj_di) {
                    $obj_needs_item->setDatastoreClient($obj_di->make(DatastoreClient::class));
                }
            );
    }

    /**
     * Register application providers with the injector.
     *
     * @param array $providers
     */
    public function registerProviders(array $providers) {
        foreach($providers as $interface => $class) {
            $this->addInterfaceAlias($interface, $class);
        }
    }

    /**
     * Get the injector.
     *
     * @return Injector
     */
    public function getInjector() {
        return $this->obj_injector;
    }

}