<?php declare(strict_types=1);

namespace App\Model\Database\Entity;

use DateTime;

/**
 * Base entity
 */
abstract class Entity
{

	/**
	 * @return string
	 */
	protected function getCurrentDate(): string
	{
		return (new DateTime())->format(DATE_W3C);
	}

}
