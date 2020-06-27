<?php
declare(strict_types=1);

namespace App\Model\Database\Repository;

use Doctrine\ORM\EntityRepository as DoctrineEntityRepository;

/**
 * Custom base EntityRepository
 */
abstract class EntityRepository extends DoctrineEntityRepository
{

	/**
	 * @param string $value
	 * @param string $key
	 * @return mixed[]
	 */
	public function findPairs($value, $key = 'id'): array
	{
		$select = [];
		$categories = $this->createQueryBuilder('e')
			->select('e.' . $key, 'e.' . $value)
			->getQuery()
			->getArrayResult();
		foreach ($categories as $category) {
			$select[$category[$key]] = $category[$value];
		}
		return $select;
	}

}
