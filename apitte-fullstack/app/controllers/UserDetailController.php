<?php declare(strict_types = 1);

namespace App\Controllers;

use Apitte\Core\Annotation\Controller\ControllerPath;
use Apitte\Core\Annotation\Controller\Method;
use Apitte\Core\Annotation\Controller\Path;
use Apitte\Core\Annotation\Controller\RequestParameter;
use Apitte\Core\Annotation\Controller\RequestParameters;
use Apitte\Core\Http\ApiRequest;

/**
 * @ControllerPath("/users")
 */
final class UserDetailController extends BaseV1Controller
{

	/**
	 * @Path("/user/{id}")
	 * @Method("GET")
	 * @RequestParameters({
	 * 		@RequestParameter(name="id", type="int", description="My favourite user ID"),
	 * 		@RequestParameter(name="flag", type="int", description="Activated or deactivated", in="query")
	 * })
	 */
	public function detail(ApiRequest $request): array
	{
		return ['user' => [
			'id' => $request->getParameter('id'),
			'type' => gettype($request->getParameter('id')),
			'nick' => 'Felix',
			'request' => [
				'attributes' => $request->getAttributes(),
				'parameters' => $request->getParameters(),
			],
		]];
	}


}
