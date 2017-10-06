<?php

namespace App\Controllers;

use Apitte\Core\Annotation\Controller\Controller;
use Apitte\Core\Annotation\Controller\Method;
use Apitte\Core\Annotation\Controller\Path;
use Apitte\Core\Annotation\Controller\RootPath;
use Apitte\Core\Annotation\Controller\Tag;
use Apitte\Core\Schema\ApiSchema;
use Apitte\Mapping\Http\ApiRequest;
use Apitte\Mapping\Http\ApiResponse;
use Apitte\Negotiation\Http\ArrayEntity;

/**
 * @Controller
 * @RootPath("/meta")
 * @Tag(name="foo")
 */
final class MetaController extends BaseV1Controller
{

	/** @var ApiSchema @inject */
	public $schema;

	/**
	 * @Path("/schema")
	 * @Method("GET")
	 */
	public function index(ApiRequest $request, ApiResponse $response)
	{
		return $response->withEntity(ArrayEntity::from(['schema' => $this->schema->getEndpointByGroup('apiv1')]));
	}

	/**
	 * @Path("/foo")
	 * @Method("GET")
	 */
	public function foo(ApiRequest $request, ApiResponse $response)
	{
		return $response->withEntity(ArrayEntity::from(['schema' => $this->schema->getEndpointsByTag('foo')]));
	}

}
