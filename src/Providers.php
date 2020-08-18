<?php namespace CameronSmith\GAEManagerAPI;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use CameronSmith\GAEManagerAPI\Http\Request;
use CameronSmith\GAEManagerAPI\Http\Response;
use CameronSmith\GAEManagerAPI\Data\Repository\ImageInterface;
use CameronSmith\GAEManagerAPI\Data\Repository\Datastore\Image;
use CameronSmith\GAEManagerAPI\Data\Repository\VersionInterface;
use CameronSmith\GAEManagerAPI\Data\Repository\Datastore\Version;


class Providers
{
    /**
     * Abstraction to concrete providers.
     */
    const APP = [
        // HTTP
        ServerRequestInterface::class => Request::class,
        ResponseInterface::class => Response::class,

        // Repos
        VersionInterface::class => Version::class,
        ImageInterface::class => Image::class,
    ];
}