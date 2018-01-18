<?php

namespace App\Controllers;

use Apitte\Core\Annotation\Controller\Controller;
use Apitte\Core\Annotation\Controller\ControllerPath;
use Apitte\Core\Annotation\Controller\Method;
use Apitte\Core\Annotation\Controller\Path;
use Apitte\Core\Annotation\Controller\RequestMapper;
use Apitte\Core\Http\ApiRequest;

/**
 * @Controller
 * @ControllerPath("/tasks")
 */
final class TaskController extends BaseV1Controller
{

	/**
	 * @Path("/filter")
	 * @Method("GET")
	 * @RequestMapper(entity="App\Controllers\Entity\FilterTasks")
	 */
	public function filter(ApiRequest $request)
	{
		return [
			'tasks' => [],
			'filter' => $request->getEntity()->toArray(),
		];
	}

}
