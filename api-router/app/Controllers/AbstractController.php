<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Http\ApiResponseFormatter;
use Nette\Application\IPresenter;

abstract class AbstractController implements IPresenter
{

	/**
	 * @var ApiResponseFormatter
	 */
	protected $apiResponseFormatter;


	public function __construct(ApiResponseFormatter $apiResponseFormatter)
	{
		$this->apiResponseFormatter = $apiResponseFormatter;
	}
}
