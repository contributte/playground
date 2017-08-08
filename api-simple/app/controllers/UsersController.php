<?php

namespace App\Controllers;

use Contributte\Api\Annotation\Controller\Controller;
use Contributte\Api\Annotation\Controller\Method;
use Contributte\Api\Annotation\Controller\Path;
use Contributte\Api\Annotation\Controller\RootPath;
use Contributte\Api\Http\ApiRequest;
use Contributte\Api\Http\ApiResponse;

/**
 * @Controller
 * @RootPath("/users")
 */
final class UsersController extends BaseController
{

	/**
	 * @Path("/")
	 * @Method("GET")
	 * @param ApiRequest $request
	 * @param ApiResponse $response
	 * @return ApiResponse
	 */
	public function index(ApiRequest $request, ApiResponse $response)
	{
		return $response->writeJsonBody(['data' => [
			['id' => 1, 'nick' => 'Chuck Norris'],
			['id' => 2, 'nick' => 'Felix'],
		]]);
	}

	/**
	 * @Path("/user/{id}")
	 * @Method("GET")
	 * @param ApiRequest $request
	 * @param ApiResponse $response
	 * @return ApiResponse
	 */
	public function detail(ApiRequest $request, ApiResponse $response)
	{
		return $response->writeJsonBody(['data' => [
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
	 * @param ApiRequest $request
	 * @param ApiResponse $response
	 * @return ApiResponse
	 */
	public function create(ApiRequest $request, ApiResponse $response)
	{
		return $response->writeJsonBody(['data' => [
			'raw' => (string) $request->getBody(),
			'parsed' => $request->getJsonBody(),
		]]);
	}

	/**
	 * @Path("/meta")
	 * @Method("GET")
	 * @param ApiRequest $request
	 * @param ApiResponse $response
	 * @return ApiResponse
	 */
	public function meta(ApiRequest $request, ApiResponse $response)
	{
		return $response->writeJsonBody(['data' => [
			'params' => $request->getQueryParams(),
			'attributes' => $request->getAttributes(),
			'cookies' => $request->getCookieParams(),
			'server' => $request->getServerParams(),
			'headers' => $request->getHeaders(),
		]]);
	}

}
