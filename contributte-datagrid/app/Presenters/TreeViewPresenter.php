<?php declare(strict_types = 1);

namespace App\Presenters;

use App\UI\TEmptyLayoutView;
use Dibi\Connection;
use Dibi\Fluent;
use Ublaboo\DataGrid\Column\Action\Confirmation\StringConfirmation;
use Ublaboo\DataGrid\DataGrid;

final class TreeViewPresenter extends AbstractPresenter
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

		$join = $this->dibiConnection->select('COUNT(id) AS count, parent_category_id')
			->from('categories')
			->groupBy('parent_category_id');

		$fluent = $this->dibiConnection
			->select('c.*, c_b.count as has_children')
			->from('categories', 'c')
			->leftJoin($join, 'c_b')
			->on('c_b.parent_category_id = c.id')
			->where('c.parent_category_id IS NULL');

		$grid->setDataSource($fluent);

		$grid->setSortable();

		$grid->setTreeView([$this, 'getChildren'], 'has_children');

		$grid->addColumnText('name', 'Name');
		$grid->addColumnText('name2', 'Name2', 'name');
		$grid->addColumnText('id', 'Id')
			->setAlign('center');

		$columnStatus = $grid->addColumnStatus('status', 'Status');

		$columnStatus
			->addOption('active', 'Active')
			->endOption()
			->addOption('inactive', 'Inactive')
			->setClass('btn-warning')
			->endOption()
			->addOption('deleted', 'Deleted')
			->setClass('btn-danger')
			->endOption()
			->setSortable();
		$columnStatus->onChange[] = [$this, 'changeStatus'];

		$grid->addAction('edit', 'Edit', 'edit!')
			->setIcon('pencil pencil-alt')
			->setClass('btn btn-xs btn-default btn-secondary ajax')
			->setTitle('Edit');

		$grid->addAction('delete', '', 'delete!')
			->setIcon('trash')
			->setTitle('Delete')
			->setClass('btn btn-xs btn-danger ajax')
			->setConfirmation(
				new StringConfirmation('Do you really want to delete example %s?', 'name')
			);

		return $grid;
	}


	/**
	 * @param mixed $parentCategoryId
	 */
	public function getChildren($parentCategoryId): Fluent
	{
		$join = $this->dibiConnection->select('COUNT(id) AS count, parent_category_id')
			->from('categories')
			->groupBy('parent_category_id');

		return $this->dibiConnection
			->select('c.*, c_b.count as has_children')
			->from('categories', 'c')
			->leftJoin($join, 'c_b')
			->on('c_b.parent_category_id = c.id')
			->where('c.parent_category_id = ?', (int) $parentCategoryId);
	}



	/**
	 * @param mixed $itemId
	 * @param mixed $prevId
	 * @param mixed $nextId
	 * @param mixed $parentId
	 */
	public function handleSort($itemId, $prevId, $nextId, $parentId): void
	{
		$this->flashMessage(
			sprintf(
				'Item id: %s, Previous id: %s, Next id: %s, Parent id: %s (only in tree view)',
				$itemId,
				$prevId,
				$nextId,
				$parentId
			),
			'success'
		);

		if ($this->isAjax()) {
			$this->redrawControl('flashes');
		} else {
			$this->redirect('this');
		}
	}


	public function handleEdit(): void
	{
		$this->flashMessage('Edited!', 'success');

		if ($this->isAjax()) {
			$this->redrawControl('flashes');
		} else {
			$this->redirect('this');
		}
	}


	public function handleDelete(): void
	{
		$this->flashMessage('Deleted!', 'info');

		if ($this->isAjax()) {
			$this->redrawControl('flashes');
		} else {
			$this->redirect('this');
		}
	}

}
