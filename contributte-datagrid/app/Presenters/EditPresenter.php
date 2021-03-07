<?php declare(strict_types = 1);

namespace App\Presenters;

use App\UI\TEmptyLayoutView;
use Dibi\Connection;
use Dibi\Row;
use Nette\Application\UI\Presenter;
use Nette\Forms\Container;
use Nette\Utils\Html;
use Ublaboo\DataGrid\DataGrid;

final class EditPresenter extends Presenter
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

		$grid->addColumnNumber('id', 'Id')
			->setSortable()
			->setAlign('left');

		$grid->addColumnText('name', 'Name')
			->setSortable()
			->setEditableCallback(function ($id, $value): void {
				$this->flashMessage(sprintf('Id: %s, new value: %s', $id, $value));
				$this->redrawControl('flashes');
			})->addCellAttributes(['class' => 'text-center']);

		$grid->addColumnLink('link', 'Link', 'this#demo', 'name', ['id', 'surname' => 'name'])
			->setEditableValueCallback(
				function (Row $row) {
					return $row['name'];
				}
			)
			->setEditableCallback(function ($id, $value): string {
				$this->flashMessage(sprintf('Id: %s, new value: %s', $id, $value));
				$this->redrawControl('flashes');

				$link = Html::el('a')
					->href($this->link('this#demo', ['id' => $id]))
					->setText($value);

				return (string) $link;
			})->addCellAttributes(['class' => 'text-center']);

		$grid->addColumnStatus('status', 'Status');

		$inlineEdit = $grid->addInlineEdit();

		$inlineEdit->onControlAdd[] = function ($container): void {
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

		$inlineEdit->onSetDefaults[] = function (Container $container, Row $row): void {
			$container->setDefaults([
				'id' => $row['id'],
				'name' => $row['name'],
				'birth_date' => $row['birth_date']->format('j. n. Y'),
				'link' => $row['name'],
				'status' => $row['status'],
			]);
		};

		$inlineEdit->onSubmit[] = function ($id, $values): void {
			$this->flashMessage('Record was updated! (not really)', 'success');
			$this->redrawControl('flashes');
		};

		$inlineEdit->setShowNonEditingColumns();

		return $grid;
	}

}
