<?php declare(strict_types = 1);

namespace App\UI;

use Nette\Application\Request;
use Nette\Application\UI\Presenter;
use Nette\UnexpectedValueException;
/**
 * @mixin Presenter
 */
trait TEmptyLayoutView
{

	/**
	 * @persistent
	 * @var bool
	 */
	public $inFrame;

	public function renderDefault(): void
	{
		/**
		 * @var Request
		 */
		$request = $this->getRequest();

		if ($request instanceof Request)
		{
			if ($request->getParameter('inFrame') == true)
			{
				$this->setLayout(__DIR__ . '/../templates/@layout.inFrame.latte');
			}
		} else {
			throw new UnexpectedValueException('Presenter->getRequest() does not return instance of Nette\Application\Request');
		}

		
	}

}
