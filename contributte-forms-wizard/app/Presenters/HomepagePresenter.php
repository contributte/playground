<?php

declare(strict_types=1);

namespace App\Presenters;

use Contributte\FormWizard\Wizard;
use Nette;

final class HomepagePresenter extends Nette\Application\UI\Presenter
{

	/** @var Wizard @inject */
	public $wizard;

	public function handleChangeStep(int $step): void
	{
		$this['wizard']->setStep($step);

		$this->redirect('wizard'); // Optional, hides parameter from URL
	}

	protected function createComponentWizard(): Wizard
	{
		return $this->wizard;
	}
}
