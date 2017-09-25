<?php

namespace App\Controllers;

use Apitte\Core\Annotation\Controller\Controller;
use Apitte\Core\Annotation\Controller\Method;
use Apitte\Core\Annotation\Controller\Path;
use Apitte\Core\Annotation\Controller\RootPath;
use Apitte\Core\Exception\Api\ClientErrorException;
use Apitte\Core\Exception\Api\ServerErrorException;
use RuntimeException;

/**
 * @Controller
 * @RootPath("/error")
 */
final class ErrorController extends BaseV1Controller
{

	/**
	 * @Path("/client")
	 * @Method("GET")
	 */
	public function client()
	{
		throw ClientErrorException::create()
			->withCode(403)
			->withContext(['a' => 'b']);
	}

	/**
	 * @Path("/server")
	 * @Method("GET")
	 */
	public function server()
	{
		throw ServerErrorException::create()
			->withCode(505)
			->withContext(['a' => 'b']);
	}

	/**
	 * @Path("/custom")
	 * @Method("GET")
	 */
	public function custom()
	{
		throw new RuntimeException('Runtime error', 0, NULL);
	}

}
