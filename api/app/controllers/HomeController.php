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
 * @RootPath("/")
 */
final class HomeController extends BaseController
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
		return $response->writeJsonBody(['data' => ['Welcome']]);
	}

}
