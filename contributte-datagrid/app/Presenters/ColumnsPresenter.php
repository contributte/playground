<?php

declare(strict_types=1);

namespace App\Presenters;

use App\UI\TEmptyLayoutView;
use Dibi\Connection;
use Dibi\Row;
use Ublaboo\DataGrid\AggregationFunction\FunctionSum;
use Ublaboo\DataGrid\AggregationFunction\IAggregationFunction;
use Ublaboo\DataGrid\AggregationFunction\ICommonAggregation;
use Ublaboo\DataGrid\AggregationFunction\IMultipleAggregationFunction;
use Ublaboo\DataGrid\Column\ColumnLink;
use Ublaboo\DataGrid\Column\ColumnStatus;
use Ublaboo\DataGrid\DataGrid;

final class ColumnsPresenter extends AbstractPresenter
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

		$grid->setDefaultSort(['id' => 'ASC']);

		$grid->setDataSource($this->dibiConnection->select('*')->from('users'));

		$grid->setItemsPerPageList([20, 50, 100], true);

		$grid->addColumnText('id', 'Id')
			->setReplacement([
				1 => 'One',
				2 => 'Two',
				3 => 'Trhee',
			])
			->setSortable();

		$grid->addColumnLink('email', 'E-mail', 'this')
			->setSortable();

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

		$grid->addColumnText('emojis', 'Emojis (template)')
			->setTemplate(__DIR__ . '/../templates/Columns/grid/columnsEmojis.latte');

		$grid->addColumnDateTime('birth_date', 'Birthday')
			->setFormat('j. n. Y')
			->setSortable();

		$grid->addColumnNumber('age', 'Age')
			->setRenderer(function(Row $row): int {
				return $row['birth_date']->diff(new \DateTime)->y;
			});

		$grid->setColumnsHideable();

		/*$grid->setColumnsSummary(['id'])
			->setRenderer(function(int $summary, string $column): string {
				return 'Summary renderer: ' . $summary . ' $';
			});*/

		$grid->addColumnCallback('status', function(ColumnStatus $column, Row $row) {
			if ($row['id'] === 3) {
				$column->removeOption('active');
			}
		});

		$grid->addColumnCallback('email', function(ColumnLink $column, Row $row) {
			if ($row['id'] === 3) {
				$column->setRenderer(function() {
					return '';
				});
			}
		});

		// $grid->addAggregationFunction('status', new FunctionSum('id'));

		$grid->setMultipleAggregationFunction(
			new class implements IMultipleAggregationFunction
			{

				/**
				 * @var int
				 */
				private $idsSum = 0;

				/**
				 * @var float
				 */
				private $avgAge = 0.0;


				public function getFilterDataType(): string
				{
					return IAggregationFunction::DATA_TYPE_PAGINATED;
				}


				public function processDataSource($dataSource): void
				{
					$this->idsSum = (int) $dataSource->getConnection()
						->select('SUM([id])')
						->from($dataSource, '_')
						->fetchSingle();

					$this->avgAge = round((float) $dataSource->getConnection()
						->select('AVG(YEAR([birth_date]))')
						->from($dataSource, '_')
						->fetchSingle());
				}


				public function renderResult(string $key)
				{
					if ($key === 'id') {
						return 'Ids sum: ' . $this->idsSum;
					} elseif ($key === 'age') {
						return 'Avg Age: ' . (int) (date('Y') - $this->avgAge);
					}
				}
			}
		);

		return $grid;
	}
}
