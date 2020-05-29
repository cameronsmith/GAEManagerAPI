<?php namespace UKCASmith\GAEManagerAPI;

class Providers
{
    const APP = [
        'Psr\Http\Message\ServerRequestInterface' => 'Slim\Http\Request',
        'Psr\Http\Message\ResponseInterface' => 'Slim\Http\Response',
    ];
}