<?php declare(strict_types = 1);

namespace App\Controllers;

use Apitte\Core\Annotation\Controller\ControllerPath;
use Apitte\Core\Annotation\Controller\Method;
use Apitte\Core\Annotation\Controller\Negotiation;
use Apitte\Core\Annotation\Controller\Negotiations;
use Apitte\Core\Annotation\Controller\Path;
use Apitte\Core\Http\ApiRequest;
use Apitte\Core\Http\ApiResponse;
use Apitte\Negotiation\Http\ArrayEntity;

/**
 * @ControllerPath("/users")
 */
final class UsersController extends BaseV1Controller
{

	/**
	 * @Path("/")
	 * @Method("GET")
	 * @Negotiations({
	 * 		@Negotiation (suffix=".csv")
	 * })
	 */
	public function index(ApiRequest $request, ApiResponse $response): ApiResponse
	{
		return $response
			->withAddedHeader('xyz', 123)
			->withEntity(ArrayEntity::from([
				['id' => 1, 'nick' => 'Chuck Norris'],
				['id' => 2, 'nick' => 'Felix'],
			]));
	}

	/**
	 * @Path("/create")
	 * @Method("POST")
	 */
	public function create(ApiRequest $request): array
	{
		return ['data' => [
			'raw' => $request->getContentsCopy(),
			'parsed' => $request->getParsedBody(),
			'jsonbody' => $request->getJsonBody(),
		]];
	}

	/**
	 * @Path("/email")
	 * @Method("GET")
	 */
	public function email(): string
	{
		return 'foo@bar.cz';
	}

}
