<?php

declare(strict_types=1);

namespace App\Model\Database\Repository;

/**
 * Custom BookRepository
 */
final class BookRepository extends EntityRepository
{

	public function getById($id)
	{
		return $this->findOneBy(
			[
				'id' => $id,
			]
		);
	}

}
