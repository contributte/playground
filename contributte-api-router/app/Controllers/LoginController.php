<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Http\ApiResponse;
use Nette\Application\IResponse;
use Nette\Application\Request;
use Contributte\ApiRouter\ApiRoute;

/**
 * API for logging users in
 * 
 * @ApiRoute(
 *      "/api/login",
 *      methods={
 * 		    "POST"="run"
 *      },
 *      presenter="Login",
 *      section="Login",
 *      format="json"
 * )
 */
final class LoginController extends AbstractController
{
	public function run(Request $request): IResponse
	{
		return new ApiResponse($this->apiResponseFormatter->formatMessage('Hello'));
	}
}
