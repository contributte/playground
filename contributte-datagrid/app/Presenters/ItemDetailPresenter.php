<?php

declare(strict_types=1);

namespace App\Presenters;

use Dibi\Connection;
use Dibi\Row;
use Nette\Application\UI\Presenter;
use Ublaboo\DataGrid\DataGrid;

final class ItemDetailPresenter extends Presenter
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

		$grid->setItemsPerPageList([20, 50, 100], true);

		$grid->addColumnText('id', 'Id')
			->setSortable();

		$grid->addColumnText('email', 'E-mail')
			->setSortable()
			->setFilterText();

		$grid->addColumnText('name', 'Name')
			->setFilterText();

		$grid->addColumnDateTime('birth_date', 'Birthday')
			->setFormat('j. n. Y');

		$grid->setItemsDetail();

		$grid->setTemplateFile(__DIR__ . '/../templates/ItemDetail/grid/item-detail-grid.latte');

		return $grid;
	}
}
