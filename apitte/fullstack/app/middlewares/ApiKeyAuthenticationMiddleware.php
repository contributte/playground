<?php

namespace App\Middlewares;

use Contributte\Psr7\Psr7Response;
use Contributte\Psr7\Psr7ServerRequest;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

final class ApiKeyAuthenticationMiddleware
{
	/**
	 * @param Psr7ServerRequest  $request
	 * @param Psr7Response       $response
	 * @param callable           $next
	 *
	 * @return ResponseInterface
	 */
	public function __invoke(RequestInterface $request, ResponseInterface $response, callable $next): ResponseInterface
	{
		if (!$apiKey = $request->getQueryParam('apiKey', NULL)) {
			return $this->notAuthenticated($response, 'Parameter apiKey not provided');
		}

		if (!$user = $this->getUser($apiKey)) {
			return $this->notAuthenticated($response, 'Provided apiKey was not found');
		}

		return $next($request->withAttribute('user', $user), $response);
	}

	private function getUser(string $apiKey): \stdClass
	{
		if ($apiKey !== 'taeghah4eewief1DoQuaiChi') {
			return NULL;
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
