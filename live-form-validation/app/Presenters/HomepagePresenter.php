<?php declare(strict_types = 1);

namespace App\Presenters;

use Contributte\Forms\IApplicationFormFactory;
use Contributte\Forms\Renderers\Bootstrap4VerticalRenderer;
use Nette\Application\UI\Form;
use Nette\Application\UI\Presenter;

class HomepagePresenter extends Presenter
{

	/** @var IApplicationFormFactory */
	private $formFactory;

	public function __construct(IApplicationFormFactory $formFactory)
	{
		parent::__construct();
		$this->formFactory = $formFactory;
	}

	protected function createComponentExampleForm(): Form
	{
		$form = $this->formFactory->create();
		$form->setRenderer(new Bootstrap4VerticalRenderer());

		$form->addText('name', 'Name:')
			->setRequired();

		$form->addPassword('password', 'Password:')
			->setRequired()
			->addRule(Form::MIN_LENGTH, 'Password must bea at least %d characters long', 6);

		$form->addPassword('passwordVerify', 'Password again:')
			->setRequired('Please set the password again for check')
			->addRule(Form::EQUAL, 'Passwords are not equal', $form['password']);

		$form->addSubmit('signup', 'Sign up');

		$form->onSuccess[] = function (Form $form) {
			dump($form->getValues());
			bdump($form->getValues());
		};

		return $form;
	}

}
