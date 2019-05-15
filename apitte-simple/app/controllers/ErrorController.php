<?php declare(strict_types = 1);

namespace App\Controllers;

use Apitte\Core\Annotation\Controller\ControllerPath;
use Apitte\Core\Annotation\Controller\Method;
use Apitte\Core\Annotation\Controller\Path;
use RuntimeException;

/**
 * @ControllerPath("/error")
 */
final class ErrorController extends BaseController
{

	/**
	 * @Path("/")
	 * @Method("GET")
	 */
	public function custom(): void
	{
		throw new RuntimeException('Unexpected exception', 0, NULL);
	}

}
