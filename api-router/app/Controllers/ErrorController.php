<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Http\ApiResponse;
use Nette\Application\IResponse;
use Nette\Application\Request;

final class ErrorController extends AbstractController
{
	public function run(Request $request): IResponse
	{
		$exception = $request->getParameter('exception');

		/**
		 * @todo Log exception
		 */

		return new ApiResponse($this->apiResponseFormatter->formatException($exception));
	}
}
