<?php declare(strict_types = 1);

namespace App\UI;

use App\Presenters\AbstractPresenter;

/**
 * @mixin AbstractPresenter
 */
trait TEmptyLayoutView
{

	/**
	 * @persistent
	 * @var bool
	 */
	public $inFrame;

	public function renderDefault()
	{
		if ($this->getRequest()->getParameter('inFrame') == true)
		{
			$this->setLayout(__DIR__ . '/../templates/@layout.inFrame.latte');
		}
	}

}
