<?php

declare(strict_types=1);

namespace App\Presenters;

use Dibi\Connection;
use Dibi\Fluent;
use Dibi\Row;
use Nette\Application\UI\Presenter;
use Nette\Utils\ArrayHash;
use Ublaboo\DataGrid\DataGrid;

abstract class AbstractPresenter extends Presenter
{

	/**
	 * @var Connection
	 * @inject
	 */
	public $dibiConnection;


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
			$this->flashMessage('Status changed');
			$this->redrawControl('flashes');
		} else {
			$this->redirect('this');
		}
	}
}
