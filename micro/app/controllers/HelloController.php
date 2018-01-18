<?php

namespace App\Controllers;

use Apitte\Core\Annotation\Controller\Controller;
use Apitte\Core\Annotation\Controller\ControllerPath;
use Apitte\Core\Annotation\Controller\Method;
use Apitte\Core\Annotation\Controller\Path;
use Apitte\Core\Annotation\Controller\RequestParameter;
use Apitte\Core\Annotation\Controller\RequestParameters;
use Apitte\Core\Http\ApiRequest;
use Apitte\Core\Http\ApiResponse;
use Apitte\Core\UI\Controller\AbstractController;

/**
 * @Controller
 * @ControllerPath("/")
 */
final class HelloController extends AbstractController
{

	/**
	 * @Path("/")
	 * @Method("GET")
	 */
	public function index(ApiRequest $request, ApiResponse $response)
	{
		return $response->writeJsonBody(['hello' => ['world']]);
	}

	/**
	 * @Path("/filter")
	 * @Method("GET")
	 * @RequestParameters({
	 *     @RequestParameter(name="id", type="int", in="query")
	 * })
	 */
	public function filter(ApiRequest $request, ApiResponse $response)
	{
		return $response->writeJsonBody(['filter' => [$request->getParameters()]]);
	}

}
