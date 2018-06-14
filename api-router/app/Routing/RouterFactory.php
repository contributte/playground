<?php

declare(strict_types=1);

namespace App\Routing;

use Nette\Application\Routers\RouteList;

final class RouterFactory
{
	public function create(): RouteList
	{
		$router = new RouteList;

		return $router;
	}
}
