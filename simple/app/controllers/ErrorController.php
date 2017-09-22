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
 * @RootPath("/error")
 */
final class ErrorController extends BaseController
{

	/**
	 * @Path("/")
	 * @Method("GET")
	 */
	public function custom(ApiRequest $request, ApiResponse $response)
	{
		throw new \RuntimeException('Runtime exception', 0, NULL);
	}

}
