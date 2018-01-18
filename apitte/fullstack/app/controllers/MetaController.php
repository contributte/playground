<?php

namespace App\Controllers;

use Apitte\Core\Annotation\Controller\Controller;
use Apitte\Core\Annotation\Controller\ControllerPath;
use Apitte\Core\Annotation\Controller\Method;
use Apitte\Core\Annotation\Controller\Path;
use Apitte\Core\Annotation\Controller\Tag;
use Apitte\Core\Http\ApiRequest;
use Apitte\Core\Http\ApiResponse;
use Apitte\Core\Schema\Schema;
use Apitte\Core\Schema\SchemaInspector;
use Apitte\Negotiation\Http\ArrayEntity;

/**
 * @Controller
 * @ControllerPath("/meta")
 * @Tag(name="foo")
 */
final class MetaController extends BaseV1Controller
{

	/** @var Schema */
	private $schema;

	/** @var SchemaInspector */
	private $inspector;

	/**
	 * @param Schema $schema
	 */
	public function __construct(Schema $schema)
	{
		$this->schema = $schema;
		$this->inspector = new SchemaInspector($schema);
	}

	/**
	 * @Path("/schema")
	 * @Method("GET")
	 */
	public function index(ApiRequest $request, ApiResponse $response)
	{
		return $response->withEntity(ArrayEntity::from(['schema' => $this->inspector->getEndpointByGroup('v1')]));
	}

	/**
	 * @Path("/foo")
	 * @Method("GET")
	 */
	public function foo(ApiRequest $request, ApiResponse $response)
	{
		return $response->withEntity(ArrayEntity::from(['schema' => $this->inspector->getEndpointsByTag('foo')]));
	}

}
