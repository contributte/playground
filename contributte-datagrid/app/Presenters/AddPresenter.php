<?php

declare(strict_types=1);

namespace App\Presenters;

use App\UI\TEmptyLayoutView;
use Dibi\Connection;
use Nette\Application\UI\Presenter;
use Ublaboo\DataGrid\DataGrid;

final class AddPresenter extends Presenter
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
			->setFilterText();

		$grid->addColumnText('name', 'Name')
			->setFilterText();

		$grid->addColumnStatus('status', 'Status');

		$inlineAdd = $grid->addInlineAdd();

		$inlineAdd->setPositionTop()
			->onControlAdd[] = function($container) {
				$container->addText('name', '')
					->setRequired('aaa');
				$container->addText('birth_date', '');
				$container->addText('link', '');
				$container->addSelect('status', '', [
					'active' => 'Active',
					'inactive' => 'Inactive',
					'deleted' => 'Deleted',
				]);
			};

		$inlineAdd->onSubmit[] = function($values) {
			$this->flashMessage('Record was added! (not really)', 'success');
			$this->redrawControl('flashes');
		};

		return $grid;
	}
}
