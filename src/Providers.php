<?php namespace CameronSmith\GAEManagerAPI;

class Providers
{
    const APP = [
        'Psr\Http\Message\ServerRequestInterface' => 'CameronSmith\GAEManagerAPI\Http\Request',
        'Psr\Http\Message\ResponseInterface' => 'Slim\Http\Response',
    ];
}