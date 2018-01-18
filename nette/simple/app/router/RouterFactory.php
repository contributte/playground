<?php

namespace App;

use Apitte\Presenter\ApiRoute;
use Nette;
use Nette\Application\Routers\Route;
use Nette\Application\Routers\RouteList;


class RouterFactory
{
	use Nette\StaticClass;

	/**
	 * @return Nette\Application\IRouter
	 */
	public static function createRouter()
	{
		$router = new RouteList;
		$router[] = new ApiRoute('api');
		$router[] = new Route('<presenter>/<action>', 'Homepage:default');
		return $router;
	}
}
