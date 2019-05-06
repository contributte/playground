<?php

declare(strict_types=1);

namespace App\Presenters;

use Dibi\Connection;
use Dibi\Row;
use Nette\Application\UI\Presenter;
use Ublaboo\DataGrid\DataGrid;

class HomepagePresenter extends Presenter
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

		$grid->addColumnText('id', '#');
		$grid->addColumnText('email', 'E-mail');
		$grid->addColumnText('name', 'Name');
		$grid->addColumnDateTime('birth_date', 'Birthday')
			->setFormat('j. n. Y');
		$grid->addColumnNumber('age', 'Age')
			->setRenderer(function(Row $row): int {
				return $row['birth_date']->diff(new \DateTime)->y;
			});

		return $grid;
	}
}
