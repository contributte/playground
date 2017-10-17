<?php

namespace App\Controllers;

use Apitte\Core\Annotation\Controller\Controller;
use Apitte\Core\Annotation\Controller\ControllerPath;
use Apitte\Core\Annotation\Controller\Method;
use Apitte\Core\Annotation\Controller\Path;
use Apitte\Core\Http\ApiRequest;
use Apitte\Core\Http\ApiResponse;

/**
 * @Controller
 * @ControllerPath("/users")
 */
final class UsersController extends BaseController
{

	/**
	 * @Path("/")
	 * @Method("GET")
	 */
	public function index(ApiRequest $request, ApiResponse $response)
	{
		return $response
			->withAddedHeader('xyz', 123)
			->writeJsonBody(['users' => [
				['id' => 1, 'nick' => 'Chuck Norris'],
				['id' => 2, 'nick' => 'Felix'],
			]]);
	}

	/**
	 * @Path("/user/{id}")
	 * @Method("GET")
	 */
	public function detail(ApiRequest $request, ApiResponse $response)
	{
		return $response
			->writeJsonBody(['user' => [
				'id' => $request->getParameter('id'),
				'nick' => 'Felix',
				'request' => [
					'attributes' => $request->getAttributes(),
					'parameters' => $request->getParameters(),
				],
			]]);
	}

	/**
	 * @Path("/create")
	 * @Method("POST")
	 */
	public function create(ApiRequest $request, ApiResponse $response)
	{
		return $response
			->writeJsonBody(['data' => [
				'content' => (string) $request->getContents(),
				'parsed' => $request->getParsedBody(),
			]]);
	}

	/**
	 * @Path("/meta")
	 * @Method("GET")
	 */
	public function meta(ApiRequest $request, ApiResponse $response)
	{
		return $response
			->writeJsonBody(['data' => [
				'params' => $request->getQueryParams(),
				'attributes' => $request->getAttributes(),
				'cookies' => $request->getCookieParams(),
				'server' => $request->getServerParams(),
				'headers' => $request->getHeaders(),
			]]);
	}

}
