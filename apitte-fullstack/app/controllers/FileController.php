<?php declare(strict_types = 1);

namespace App\Controllers;

use Apitte\Core\Annotation\Controller\ControllerPath;
use Apitte\Core\Annotation\Controller\Method;
use Apitte\Core\Annotation\Controller\Path;
use Apitte\Core\Http\ApiRequest;
use Apitte\Core\Http\ApiResponse;
use GuzzleHttp\Psr7\LazyOpenStream;

/**
 * @ControllerPath("/file")
 */
final class FileController extends BaseV1Controller
{

	/**
	 * @Path("/")
	 * @Method("GET")
	 */
	public function index(ApiRequest $request, ApiResponse $response): ApiResponse
	{
		$response->getBody()->write('This is pure body content');

		return $response;
	}

	/**
	 * @Path("/download")
	 * @Method("GET")
	 */
	public function download(ApiRequest $request, ApiResponse $response): ApiResponse
	{
		return $response
			->withHeader('Content-Type', 'application/octet-stream')
			->withHeader('Content-Disposition', 'attachment; filename="' . time() . '.txt"')
			->withBody(new LazyOpenStream(__FILE__, 'r'));
	}

}
