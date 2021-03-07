<?php declare(strict_types = 1);

namespace App\Presenters;

use App\UI\TEmptyLayoutView;
use Dibi\Connection;
use Nette\Application\UI\Presenter;
use Ublaboo\DataGrid\Column\Action\Confirmation\StringConfirmation;
use Ublaboo\DataGrid\DataGrid;

final class RowPresenter extends Presenter
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

		$grid->setItemsPerPageList([20, 50, 100]);

		$grid->setRowCallback(function ($item, $tr): void {
			$tr->addClass('super-' . $item->id);
		});

		$grid->addColumnNumber('id', 'Id')
			->setAlign('left')
			->setSortable();

		$grid->addColumnText('name', 'Name')
			->setSortable();

		$grid->addColumnDateTime('birth_date', 'Birthday');

		$grid->addAction('detail', '', 'this')
			->setIcon('sun')
			->setTitle('Detail');

		$grid->addAction('delete', '', 'delete!')
			->setIcon('trash')
			->setTitle('Delete')
			->setClass('btn btn-xs btn-danger ajax')
			->setConfirmation(
				new StringConfirmation('Do you really want to delete example %s?', 'name')
			);

		$grid->addGroupAction('Delete')->onSelect[] = [$this, 'groupDelete'];

		$grid->allowRowsGroupAction(function ($item): bool {
			return $item->id % 2 === 0;
		});

		$grid->allowRowsAction('delete', function ($item): bool {
			return $item->id % 3 === 0;
		});

		$grid->allowRowsAction('detail', function ($item): bool {
			return $item->id % 4 === 0;
		});

		return $grid;
	}


	public function handleDelete(): void
	{
		$this->flashMessage('Deleted!', 'info');
		$this->redrawControl('flashes');
	}


	public function groupDelete(array $ids): void
	{
		$this->flashMessage(
			sprintf('These items: [%s] are being deleted', implode(',', $ids)),
			'info'
		);

		if ($this->isAjax()) {
			$this->redrawControl('flashes');
			$this['grid']->redrawControl();
		} else {
			$this->redirect('this');
		}
	}

}
