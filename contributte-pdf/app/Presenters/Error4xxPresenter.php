<?php declare(strict_types = 1);

namespace App\Presenters;

use Nette;

/**
 * @property-read Nette\Bridges\ApplicationLatte\Template $template
 * @property-read Nette\Application\Request               $request
 */
final class Error4xxPresenter extends Nette\Application\UI\Presenter
{

	public function startup(): void
	{
		parent::startup();
		if (!$this->request->isMethod(Nette\Application\Request::FORWARD)) {
			$this->error();
		}
	}

	public function renderDefault(Nette\Application\BadRequestException $exception): void
	{
		// load template 403.latte or 404.latte or ... 4xx.latte
		$file = __DIR__ . '/templates/Error/' . $exception->getCode() . '.latte';
		$file = is_file($file)
			? $file
			: __DIR__ . '/templates/Error/4xx.latte';
		$this->template->setFile($file);
	}

}
