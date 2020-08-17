<?php

use CameronSmith\GAEManagerAPI\Application;
use CameronSmith\GAEManagerAPI\Helpers\Path;

/**
 * Created by PhpStorm.
 * User: cameron
 * Date: 17/08/20
 * Time: 08:29
 */
trait CreateApplication
{
    /**
     * Return an application instance
     *
     * @return Application
     */
    public function getAppInstance() {
        $app = require Path::getAppPath() . '/bootstrap/app.php';
        $routes = require Path::getAppPath() . '/router/route.php';
        $app->addRoutes($routes);

        return $app;
    }

    /**
     * Clear the datastore repository.
     */
    public function clearRepository() {
        $str_reset_endpoint = 'http://' . getenv('DATASTORE_EMULATOR_HOST') . '/reset';

        $obj_ch = curl_init();
        curl_setopt($obj_ch,CURLOPT_URL, $str_reset_endpoint);
        curl_setopt($obj_ch,CURLOPT_POST,0);
        curl_setopt($obj_ch,CURLOPT_POSTFIELDS, []);
        curl_setopt($obj_ch, CURLOPT_RETURNTRANSFER, 1);
        curl_exec($obj_ch);
        curl_close($obj_ch);
    }
}