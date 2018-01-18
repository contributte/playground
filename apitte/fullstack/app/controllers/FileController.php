<?php

namespace App\Controllers;

use Apitte\Core\Annotation\Controller\Controller;
use Apitte\Core\Annotation\Controller\ControllerPath;
use Apitte\Core\Annotation\Controller\Method;
use Apitte\Core\Annotation\Controller\Path;
use Apitte\Core\Http\ApiRequest;
use Apitte\Core\Http\ApiResponse;
use GuzzleHttp\Psr7\LazyOpenStream;

/**
 * @Controller
 * @ControllerPath("/file")
 */
final class FileController extends BaseV1Controller
{

	/**
	 * @Path("/")
	 * @Method("GET")
	 */
	public function index(ApiRequest $request, ApiResponse $response)
	{
		$response->getBody()->write('This is pure body content');

		return $response;
	}

	/**
	 * @Path("/download")
	 * @Method("GET")
	 */
	public function download(ApiRequest $request, ApiResponse $response)
	{
		return $response
			->withHeader('Content-Type', 'application/octet-stream')
			->withHeader('Content-Disposition', 'attachment; filename="' . time() . '.txt"')
			->withBody(new LazyOpenStream(__FILE__, 'r'));
	}

}
