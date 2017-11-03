<?php

namespace App\Controllers;

use Apitte\Core\Annotation\Controller\Controller;
use Apitte\Core\Annotation\Controller\ControllerPath;
use Apitte\Core\Annotation\Controller\Method;
use Apitte\Core\Annotation\Controller\Negotiation;
use Apitte\Core\Annotation\Controller\Negotiations;
use Apitte\Core\Annotation\Controller\Path;
use Apitte\Core\Annotation\Controller\RequestParameter;
use Apitte\Core\Annotation\Controller\RequestParameters;
use Apitte\Core\Http\ApiRequest;
use Apitte\Core\Http\ApiResponse;
use Apitte\Negotiation\Http\ArrayEntity;

/**
 * @Controller
 * @ControllerPath("/users")
 */
final class UsersController extends BaseV1Controller
{

	/**
	 * @Path("/")
	 * @Method("GET")
	 * @Negotiations({
	 * 		@Negotiation(suffix=".csv")
	 * })
	 */
	public function index(ApiRequest $request, ApiResponse $response)
	{
		return $response
			->withAddedHeader('xyz', 123)
			->withEntity(ArrayEntity::from([
				['id' => 1, 'nick' => 'Chuck Norris'],
				['id' => 2, 'nick' => 'Felix'],
			]));
	}

	/**
	 * @Path("/user/{id}")
	 * @Method("GET")
	 * @RequestParameters({
	 * 		@RequestParameter(name="id", type="int", description="My favourite user ID")
	 * })
	 */
	public function detail(ApiRequest $request)
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

	/**
	 * @Path("/create")
	 * @Method("POST")
	 */
	public function create(ApiRequest $request)
	{
		return ['data' => [
			'raw' => (string) $request->getBodyClone(),
			'parsed' => $request->getParsedBody(),
			'jsonbody' => $request->getJsonBody(),
		]];
	}

	/**
	 * @Path("/meta")
	 * @Method("GET")
	 */
	public function meta(ApiRequest $request)
	{
		return ['data' => [
			'params' => $request->getQueryParams(),
			'attributes' => $request->getAttributes(),
			'cookies' => $request->getCookieParams(),
			'server' => $request->getServerParams(),
			'headers' => $request->getHeaders(),
		]];
	}

}
