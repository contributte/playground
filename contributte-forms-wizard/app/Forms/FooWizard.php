<?php

declare(strict_types=1);

namespace App\Forms;

use Contributte\FormWizard\Wizard;
use Nette\Application\UI\Form;

class FooWizard extends Wizard {

	private array $stepNames = [
		1 => "Skip username",
		2 => "Username",
		3 => "Email",
	];

	protected function finish(): void
	{
		$values = $this->getValues();
		bdump($values);
	}

	protected function startup(): void
	{
		$this->skipStepIf(2, function (array $values): bool {
			return isset($values[1]) && $values[1]['skip'] === true;
		});
		$this->setDefaultValues(2, function (Form $form, array $values) {
			$data = [
				'username' => 'john_doe'
			];
			$form->setDefaults($data);
		});
	}

	public function getStepData(int $step): array
	{
		return [
			'name' => $this->stepNames[$step]
		];
	}

	protected function createStep1(): Form
	{
		$form = $this->createForm();

		$form->addCheckbox('skip', 'Skip username');

		$form->addSubmit(self::NEXT_SUBMIT_NAME, 'Next');

		return $form;
	}

	protected function createStep2(): Form
	{
		$form = $this->createForm();

		$form->addText('username', 'Username')
			->setRequired();

		$form->addSubmit(self::PREV_SUBMIT_NAME, 'Back');
		$form->addSubmit(self::NEXT_SUBMIT_NAME, 'Next');

		return $form;
	}

	protected function createStep3(): Form
	{
		$form = $this->createForm();

		$form->addText('email', 'Email')
			->setRequired();

		$form->addSubmit(self::PREV_SUBMIT_NAME, 'Back');
		$form->addSubmit(self::FINISH_SUBMIT_NAME, 'Register');

		return $form;
	}
}
