<?php

namespace App\Presenters;

use Nette;


final class HomepagePresenter extends Nette\Application\UI\Presenter
{
	protected function createComponentMyForm() {
		$form = new Nette\Application\UI\Form;
		$form->addFileUpload("uploader");

		return $form;
	}

}
