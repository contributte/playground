<?php

namespace App\Model\Database\Repository;

use Doctrine\ORM\EntityRepository;

class BookRepository extends EntityRepository
{

	public function getById($id)
	{
		return $this->findOneBy([
			'id' => $id,
		]);
	}

}
