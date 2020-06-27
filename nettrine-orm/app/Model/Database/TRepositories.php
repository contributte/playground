<?php
declare(strict_types=1);

namespace App\Model\Database;

use App\Model\Database\Entity\Book;
use App\Model\Database\Entity\Category;
use App\Model\Database\Entity\Tag;
use App\Model\Database\Repository\BookRepository;
use App\Model\Database\Repository\CategoryRepository;
use App\Model\Database\Repository\TagRepository;

/**
 * Shortcuts for type hinting
 */
trait TRepositories
{

	/**
	 * @return BookRepository
	 */
	public function getBookRepository(): BookRepository
	{
		return $this->getRepository(Book::class);
	}

	/**
	 * @return CategoryRepository
	 */
	public function getCategoryRepository(): CategoryRepository
	{
		return $this->getRepository(Category::class);
	}

	/**
	 * @return TagRepository
	 */
	public function getTagRepository(): TagRepository
	{
		return $this->getRepository(Tag::class);
	}

}
