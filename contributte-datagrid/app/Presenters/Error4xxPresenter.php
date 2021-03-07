<?php declare(strict_types = 1);

namespace App\Presenters;

use Nette\Application\BadRequestException;
use Nette\Application\Request;
use Nette\Application\UI\Presenter;
use UnexpectedValueException;

class Error4xxPresenter extends Presenter
{

	public function startup(): void
	{
		parent::startup();

		if ($this->getRequest() === null) {
			throw new UnexpectedValueException();
		}

		if (!$this->getRequest()->isMethod(Request::FORWARD)) {
			$this->error();
		}
	}


	public function renderDefault(BadRequestException $exception): void
	{
		// load template 403.latte or 404.latte or ... 4xx.latte
		$file = __DIR__ . '/templates/Error/' . $exception->getCode() . '.latte';
		$this->getTemplate()->setFile(
			is_file($file) ? $file : __DIR__ . '/templates/Error/4xx.latte'
		);
	}

}
