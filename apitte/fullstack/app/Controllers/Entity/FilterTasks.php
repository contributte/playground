<?php declare(strict_types = 1);

namespace App\Controllers\Entity;

use Apitte\Core\Mapping\Request\BasicEntity;

final class FilterTasks extends BasicEntity
{

	/** @var int */
	public $taskId;

	/** @var int */
	public $userId;

	/**
	 * @param mixed  $value
	 * @return mixed
	 */
	protected function normalize(string $property, $value)
	{
		if ($property === 'taskId') {
			return (int) $value;
		}

		if ($property === 'userId') {
			return (int) $value;
		}

		return parent::normalize($property, $value);
	}

}
