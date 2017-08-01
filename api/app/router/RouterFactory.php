<?php

namespace App;

use Nette\Application\IRouter;
use Nette\Application\Routers\Route;
use Nette\Application\Routers\RouteList;
use Nette\StaticClass;

final class RouterFactory
{

    use StaticClass;

    /**
     * @return IRouter
     */
    public static function createRouter()
    {
        $router = new RouteList();

        $router[] = new Route('<presenter>/<action>/[<id>][<title>]/', 'Home:default');

        return $router;
    }

}
