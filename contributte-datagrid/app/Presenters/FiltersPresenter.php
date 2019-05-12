<?php

declare(strict_types=1);

namespace App\Presenters;

use Dibi\Connection;
use Dibi\Fluent;
use Dibi\Row;
use Nette\Application\UI\Presenter;
use Nette\Utils\ArrayHash;
use Ublaboo\DataGrid\DataGrid;

final class FiltersPresenter extends Presenter
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

		$grid->addColumnText('id', '#')
			->setFilterText()
			->setExactSearch();

		$grid->addColumnText('name', 'Name')
			->setFilterText();

		$grid->addColumnStatus('status', 'Status')
			->setFilterSelect([
				'' => 'All',
				'active' => 'Active',
				'inactive' => 'Inactive',
				'deleted' => 'Deleted',
			]);

		$grid->addColumnDateTime('birth_date', 'Birthday')
			->setFormat('j. n. Y')
			->setSortable()
			->setFilterDate();

		$grid->addColumnDateTime('birth_date_2', 'Birthday 2', 'birth_date')
			->setFormat('j. n. Y')
			->setSortable()
			->setFilterDateRange();

		$grid->addColumnNumber('age', 'Age')
			->setRenderer(function(Row $row): int {
				return $row['birth_date']->diff(new \DateTime)->y;
			})
			->setFilterRange()
			->setCondition(function(Fluent $fluent, ArrayHash $values): void {
				if ((bool) $values['from']) {
					$fluent->where('(YEAR(CURDATE()) - YEAR(birth_date)) >= ?', $values['from']);
				}

				if ((bool) $values['to']) {
					$fluent->where('(YEAR(CURDATE()) - YEAR(birth_date)) <= ?', $values['to']);
				}
			});

		return $grid;
	}


	/**
	 * @param mixed $id
	 */
	public function changeStatus($id, string $newStatus): void
	{
		$id = (int) $id;

		if (in_array($newStatus, ['active', 'inactive', 'deleted'], true)) {
			$data = ['status' => $newStatus];

			$this->dibiConnection->update('users', $data)
				->where('id = ?', $id)
				->execute();
		}

		if ($this->isAjax()) {
			$grid = $this['grid'];


			if (!$grid instanceof DataGrid) {
				throw new \UnexpectedValueException;
			}

			$grid->redrawItem($id);
		} else {
			$this->redirect('this');
		}
	}
}
