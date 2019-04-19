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

	protected function createComponentRecaptchaForm(): Form
	{
		$form = $this->formFactory->create();
		$form->setRenderer(new Bootstrap4VerticalRenderer());

		$form->addText('test', 'Test');

		//$form->addReCaptcha('recaptcha', $label = 'Captcha', $required = TRUE, $message = 'Are you bot?');
		$form->addReCaptcha('recaptcha', 'Captcha', true, 'Are you bot?');

		$form->addSubmit('send', 'Send');

		$form->onSuccess[] = function (Form $form) {
			dump($form->getValues());
			bdump($form->getValues());
		};

		return $form;
	}

}
