<?php

declare(strict_types=1);

namespace App\Presenters;

use App\UI\TEmptyLayoutView;
use Dibi\Connection;
use Dibi\Row;
use Nette\Application\UI\Presenter;
use Ublaboo\DataGrid\DataGrid;
use Ublaboo\DataGrid\Localization\SimpleTranslator;

final class LocalizationPresenter extends Presenter
{

	use TEmptyLayoutView;

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

		$grid->addColumnNumber('age', 'Age')
			->setRenderer(function(Row $row): int {
				return $row['birth_date']->diff(new \DateTime)->y;
			});


		$translator = new SimpleTranslator([
			'ublaboo_datagrid.no_item_found_reset' => 'Žádné položky nenalezeny. Filtr můžete vynulovat',
			'ublaboo_datagrid.no_item_found' => 'Žádné položky nenalezeny.',
			'ublaboo_datagrid.here' => 'zde',
			'ublaboo_datagrid.items' => 'Položky',
			'ublaboo_datagrid.all' => 'všechny',
			'ublaboo_datagrid.from' => 'z',
			'ublaboo_datagrid.reset_filter' => 'Resetovat filtr',
			'ublaboo_datagrid.group_actions' => 'Hromadné akce',
			'ublaboo_datagrid.show_all_columns' => 'Zobrazit všechny sloupce',
			'ublaboo_datagrid.hide_column' => 'Skrýt sloupec',
			'ublaboo_datagrid.action' => 'Akce',
			'ublaboo_datagrid.previous' => 'Předchozí',
			'ublaboo_datagrid.next' => 'Další',
			'ublaboo_datagrid.choose' => 'Vyberte',
			'ublaboo_datagrid.execute' => 'Provést',

			'Name' => 'Jméno',
			'Birthday' => 'Narozky',
			'Age' => 'Věk',
		]);

		$grid->setTranslator($translator);

		return $grid;
	}
}
