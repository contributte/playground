<?php declare(strict_types = 1);

namespace App\Middlewares;

use Apitte\Core\Http\ApiRequest;
use Apitte\Core\Http\ApiResponse;
use Contributte\Middlewares\IMiddleware;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use stdClass;

final class ApiKeyAuthenticationMiddleware implements IMiddleware
{

	/**
	 * @param ApiRequest  $request
	 * @param ApiResponse $response
	 */
	public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next): ResponseInterface
	{
		if (!$apiKey = $request->getQueryParam('apiKey', null)) {
			return $this->notAuthenticated($response, 'Query parameter apiKey not provided');
		}

		if (!$user = $this->getUser($apiKey)) {
			return $this->notAuthenticated($response, 'Provided apiKey was not found');
		}

		return $next($request->withAttribute('user', $user), $response);
	}

	private function getUser(string $apiKey): ?stdClass
	{
		if ($apiKey !== 'taeghah4eewief1DoQuaiChi') {
			return null;
		}

		return (object) [
			'firstname' => 'John',
			'lastname' => 'Doe',
		];
	}

	private function notAuthenticated(ResponseInterface $response, string $message): ResponseInterface
	{
		$response->getBody()->write(json_encode([
			'code' => 401,
			'status' => 'error',
			'message' => $message,
		]));

		return $response->withStatus(401)
			->withHeader('Content-Type', 'application/json');
	}

}
