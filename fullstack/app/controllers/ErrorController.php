<?php

namespace App\Controllers;

use Apitte\Core\Annotation\Controller\Controller;
use Apitte\Core\Annotation\Controller\ControllerPath;
use Apitte\Core\Annotation\Controller\Method;
use Apitte\Core\Annotation\Controller\Path;
use Apitte\Core\Exception\Api\ClientErrorException;
use Apitte\Core\Exception\Api\MessageException;
use Apitte\Core\Exception\Api\ServerErrorException;
use RuntimeException;

/**
 * @Controller
 * @ControllerPath("/error")
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
	 * @Path("/message")
	 * @Method("GET")
	 */
	public function message()
	{
		throw MessageException::create()
			->withCode(405)
			->withMessage("Foobar");
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
