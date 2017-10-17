<?php

namespace App\Controllers;

use Apitte\Core\Annotation\Controller\Controller;
use Apitte\Core\Annotation\Controller\ControllerPath;
use Apitte\Core\Annotation\Controller\Method;
use Apitte\Core\Annotation\Controller\Path;
use RuntimeException;

/**
 * @Controller
 * @ControllerPath("/error")
 */
final class ErrorController extends BaseController
{

	/**
	 * @Path("/")
	 * @Method("GET")
	 */
	public function custom()
	{
		throw new RuntimeException('Unexpected exception', 0, NULL);
	}

}
