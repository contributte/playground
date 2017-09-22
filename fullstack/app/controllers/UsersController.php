<?php

namespace App\Controllers;

use Apitte\Core\Annotation\Controller\Controller;
use Apitte\Core\Annotation\Controller\Method;
use Apitte\Core\Annotation\Controller\Path;
use Apitte\Core\Annotation\Controller\RootPath;
use Apitte\Core\Http\ApiRequest;
use Apitte\Core\Http\ApiResponse;

/**
 * @Controller
 * @RootPath("/users")
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
			->withData(['users' => [
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
			->withData(['user' => [
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
			->withData(['data' => [
				'raw' => (string) $request->getBodyClone(),
				'parsed' => $request->getParsedBody(),
				'jsonbody' => $request->getJsonBody(),
			]]);
	}

	/**
	 * @Path("/meta")
	 * @Method("GET")
	 */
	public function meta(ApiRequest $request, ApiResponse $response)
	{
		return $response
			->withData(['data' => [
				'params' => $request->getQueryParams(),
				'attributes' => $request->getAttributes(),
				'cookies' => $request->getCookieParams(),
				'server' => $request->getServerParams(),
				'headers' => $request->getHeaders(),
			]]);
	}

}
