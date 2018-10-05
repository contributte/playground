<?php declare(strict_types = 1);

namespace App\Presenters;

use Nette\Application\UI\Presenter;

class HomepagePresenter extends Presenter
{

	public function renderDefault(): void
	{
		$this->template->anyVariable = 'any value';
	}

}
