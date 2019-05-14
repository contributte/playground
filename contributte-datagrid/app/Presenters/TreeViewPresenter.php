<?php

declare(strict_types=1);

namespace App\Presenters;

use Dibi\Connection;
use Nette\Application\UI\Presenter;
use Ublaboo\DataGrid\DataGrid;

final class TreeViewPresenter extends Presenter
{

	/**
	 * @var Connection
	 * @inject
	 */
	public $dibiConnection;


	public function createComponentGrid(): DataGrid
	{
		$grid = new DataGrid;

		$grid->setDataSource($this->dibiConnection->select('*')->from('users'));

		$grid->setItemsPerPageList([20, 50, 100]);

		$grid->addColumnNumber('id', 'Id')
			->setAlign('left')
			->setSortable();

		return $grid;
	}
}
