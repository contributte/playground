<?php

declare(strict_types=1);

namespace App\Presenters;

use App\UI\TEmptyLayoutView;
use Dibi\Connection;
use Nette\Application\UI\Presenter;
use Ublaboo\DataGrid\DataGrid;

class GroupActionsPresenter extends Presenter
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

		$grid->setItemsPerPageList([20, 50, 100]);

		$grid->addColumnNumber('id', 'Id')
			->setAlign('left')
			->setSortable();

		$grid->addColumnText('name', 'Name')
			->setSortable();

		$grid->addColumnText('email', 'E-mail')
			->setSortable();

		$grid->addColumnDateTime('status', 'Status');

		$grid->addGroupAction(
			'Change user status',
			[
				'active' => 'Active',
				'inactive' => 'Inactive',
				'deleted' => 'Deleted',
			]
		)->onSelect[] = [$this, 'groupChangeStatus'];

		$grid->addGroupAction('Send', [
			'john'  => 'John',
			'joe'   => 'Joe',
			'frank' => 'Frank',
		])->onSelect[] = [$this, 'groupSend'];

		$grid->addGroupTextAction('Add note')->onSelect[] = [$this, 'groupAddNote'];

		$grid->addGroupAction('Delete')->onSelect[] = [$this, 'groupDelete'];

		$grid->addGroupButtonAction('Say hello')->onClick[] = [$this, 'sayHello'];

		return $grid;
	}


	public function groupChangeStatus(array $ids, string $newStatus): void
	{
		$this->flashMessage(
			sprintf(
				'Status of items with id: [%s] was changed to: [%s]',
				implode(',', $ids),
				$newStatus
			),
			'success'
		);

		if ($ids !== []) {
			$data = ['status' => $newStatus];

			$this->dibiConnection->update('users', $data)
				->where('id IN (?)', $ids)
				->execute();
		}

		if ($this->isAjax()) {
			$this->redrawControl('flashes');
			$this['grid']->redrawControl();
		} else {
			$this->redirect('this');
		}
	}


	public function groupAddNote(array $ids, string $value): void
	{
		$this->flashMessage(
			sprintf('Note [%s] was added to items with ID: [%s]', $value, implode(',', $ids)),
			'success'
		);

		if ($this->isAjax()) {
			$this->redrawControl('flashes');
			$this['grid']->redrawControl();
		} else {
			$this->redirect('this');
		}
	}


	public function groupSend(array $ids, string $key): void
	{
		$this->flashMessage(
			sprintf('These items: [%s] sent to: [%s]', implode(',', $ids), $key),
			'success'
		);

		if ($this->isAjax()) {
			$this->redrawControl('flashes');
			$this['grid']->redrawControl();
		} else {
			$this->redirect('this');
		}
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


	public function sayHello(array $ids): void
	{
		$this->flashMessage(
			sprintf('Hello said to: [%s]', implode(',', $ids)),
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
