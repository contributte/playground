<?php

namespace App\Controllers\Entity;

final class FilterTasks extends BaseEntity
{

	/** @var int */
	public $taskId;

	/** @var int */
	public $userId;

	/**
	 * @param string $property
	 * @param mixed $value
	 * @return mixed
	 */
	protected function normalize($property, $value)
	{
		if ($property === 'taskId') {
			return intval($value);
		} else if ($property === 'userId') {
			return intval($value);
		}

		return parent::normalize($property, $value);
	}

}
