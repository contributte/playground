<?php

declare(strict_types=1);

namespace App\Presenters;

use Dibi\Connection;
use Nette\Application\UI\Presenter;
use Ublaboo\DataGrid\DataGrid;

class Bootstrap4Presenter extends Presenter
{

	/**
	 * @var Connection
	 * @inject
	 */
	public $dibiConnection;


	public function createComponentGrid(): DataGrid
	{
		$grid = new DataGrid;

		$grid->setDataSource($this->dibiConnection->select('*')->from('user'));

		$grid->addColumnText('id', '#');
		$grid->addColumnText('email', 'E-mail');
		$grid->addColumnText('name', 'Name');
		$grid->addColumnText('surname', 'Surname');

		return $grid;
	}
}
