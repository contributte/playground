<?php declare(strict_types = 1);

namespace App\Model\Database\Advanced\Repository;

use App\Model\Database\Advanced\Entity\ArticleCategory;
use Gedmo\Tree\Entity\Repository\NestedTreeRepository;

final class ArticleCategoryRepository extends NestedTreeRepository
{

	/** @return array<ArticleCategory> */
	public function findAllOrderedCategories(): array
	{
		$qb = $this->createQueryBuilder('c');
		$qb->where('c.lvl != 0')
			->orderBy('c.lft');

		return $qb->getQuery()->getResult();
	}

	/**
	 * @return mixed[]
	 */
	public function findPairs(): array
	{
		$select = [];
		$categories = $this->createQueryBuilder('e')
			->select('e.id, e.title, e.lvl')
			->orderBy('e.lft')
			->getQuery()
			->getArrayResult();

		foreach ($categories as $category) {
			$select[$category['id']] = str_repeat('-', $category['lvl']) . ' ' . $category['title'];
		}

		return $select;
	}

}
