<?php

declare(strict_types=1);

namespace App\Presenters;

use Dibi\Connection;
use Nette\Application\UI\Presenter;
use Ublaboo\DataGrid\Column\ColumnText;
use Ublaboo\DataGrid\DataGrid;

final class ExportPresenter extends Presenter
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

		$grid->addColumnText('name', 'Name')
			->setSortable()
			->setFilterText();

		$grid->addColumnDateTime('birth_date', 'Birthday');

		$grid->addColumnText('status', 'Status');

		$grid->addExportCallback('Dump to ajax rq', function(array $rows, DataGrid $grid) {
			echo 'All fetched data were passed to export callback. Size of data: ';
			echo sizeof($rows);
			die;
		})->setAjax();

		$grid->addExportCsvFiltered('Csv export (filtered)', 'examples.csv')
			->setTitle('Csv export (filtered)');

		$columnName = new ColumnText($grid, 'name', 'name', 'Name');
		$columnEven = (new ColumnText($grid, 'even', 'even', 'Even ID (yes/no)'))
			->setRenderer(
				function($item) {
					return $item['id'] % 2 === 0 ? 'No' : 'Yes';
				}
			);

		$grid->addExportCsv('Csv export', 'examples-all.csv')
			->setTitle('Csv export')
			->setColumns([
				$columnName,
				$columnEven,
			]);

		return $grid;
	}
}
