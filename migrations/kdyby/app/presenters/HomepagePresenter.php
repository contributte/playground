<?php

namespace App\Presenters;

use Nette\Application\UI\Presenter;

class HomepagePresenter extends Presenter
{

	public function renderDefault()
	{
		$this->template->anyVariable = 'any value';
	}
}
