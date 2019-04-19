<?php declare(strict_types = 1);

namespace App;

use Apitte\Presenter\ApiRoute;
use Nette;
use Nette\Application\Routers\Route;
use Nette\Application\Routers\RouteList;

class RouterFactory
{

	use Nette\StaticClass;

	public static function createRouter(): RouteList
	{
		$router = new RouteList;
		$router[] = new ApiRoute('api');
		$router[] = new Route('<presenter>/<action>', 'Homepage:default');
		return $router;
	}
}
