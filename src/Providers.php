<?php namespace UKCASmith\GAEManagerAPI;

class Providers
{
    const APP = [
        'Psr\Http\Message\ServerRequestInterface' => 'UKCASmith\GAEManagerAPI\Http\Request',
        'Psr\Http\Message\ResponseInterface' => 'Slim\Http\Response',
    ];
}