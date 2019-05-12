<?php

declare(strict_types=1);

namespace App\Presenters;

use Dibi\Connection;
use Nette\Application\UI\Presenter;
use Ublaboo\DataGrid\Column\Action\Confirmation\StringConfirmation;
use Ublaboo\DataGrid\DataGrid;

final class ActionsPresenter extends Presenter
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

		$grid->setItemsPerPageList([20, 50, 1]);

		$grid->setSortable();

		/**
		 * Columns
		 */
		$grid->addColumnNumber('id', 'Id')
			->setAlign('left')
			->setSortable();

		$grid->addColumnText('name', 'Name')
			->setSortable();

		/**
		 * MultiAction
		 */
		$multiAction = $grid->addMultiAction('multi_blah', 'MultiAction')
			->addAction('blah', 'Blahblah', 'blah!')
			->addAction('blah2', 'Blahblah2', 'blah!', ['name']);

		$multiAction
			->getAction('blah2')
			->setIcon('check');

		/**
		 * Actions
		 */
		$grid->addAction('blah', 'Blahblah', 'blah!')
			->setClass('btn btn-xs btn-primary ajax');

		$grid->addAction('this', '')
			->setIcon('redo')
			->setClass('btn btn-xs btn-success');

		$actionCallback = $grid->addActionCallback('custom_callback', '');

		$actionCallback
			->setIcon('sun')
			->setTitle('Hello, sun')
			->setClass('btn btn-xs btn-default btn-secondary ajax');

		$actionCallback->onClick[] = function($item_id) {
			$this->flashMessage('Custom callback triggered, id: ' . $item_id);
			$this->redrawControl('flashes');
		};

		$grid->addAction('delete', '', 'delete!')
			->setIcon('trash')
			->setTitle('Delete')
			->setClass('btn btn-xs btn-danger ajax')
			->setConfirmation(
				new StringConfirmation('Do you really want to delete example %s?', 'name')
			);

		/**
		 * ToolbarButtons
		 */
		$grid->addToolbarButton('this', 'Toolbar')->addAttributes(['foo' => 'bar']);
		$grid->addToolbarButton('this#2', 'Button', ['foo' => 'bar']);

		return $grid;
	}


	public function handleSort(): void
	{
		$this->flashMessage('Sorted!');
		$this->redrawControl('flashes');
	}


	public function handleBlah(): void
	{
		$this->flashMessage('Blah');
		$this->redrawControl('flashes');
	}


	public function handleDelete(): void
	{
		$this->flashMessage('Deleted!', 'info');
		$this->redrawControl('flashes');
	}
}
 
