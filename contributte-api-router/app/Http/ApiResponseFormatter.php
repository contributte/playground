<?php

declare(strict_types=1);

namespace App\Http;


final class ApiResponseFormatter
{
	public function formatMessage(string $message): array
	{
		return [
			'status' => 'ok',
			'payload' => [
				'message' => $message,
			],
		];
	}


	public function formatPayload(array $payload): array
	{
		return [
			'status' => 'ok',
			'payload' => $payload,
		];
	}


	public function formatException(\Exception $e): array
	{
		return [
			'status' => 'error',
			'code' => $e->getCode(),
			'message' => $e->getMessage(),
		];
	}
}
