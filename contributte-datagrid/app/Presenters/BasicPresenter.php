<?php declare(strict_types = 1);

namespace App\Presenters;

use App\UI\TEmptyLayoutView;
use DateTime;
use Dibi\Connection;
use Dibi\Row;
use Nette\Application\UI\Presenter;
use Ublaboo\DataGrid\DataGrid;

final class BasicPresenter extends Presenter
{

	use TEmptyLayoutView;

	/**
	 * @var Connection
	 * @inject
	 */
	public $dibiConnection;

	public function createComponentGrid(): DataGrid
	{
		$grid = new DataGrid();

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

		$grid->addColumnNumber('age', 'Age')
			->setRenderer(function (Row $row): int {
				return $row['birth_date']->diff(new DateTime())->y;
			});

		return $grid;
	}

}
