<?php declare(strict_types=1);

namespace App\Model\Database;

use App\Model\Database\Advanced\Entity\Article;
use App\Model\Database\Advanced\Entity\ArticleCategory;
use App\Model\Database\Advanced\Repository\ArticleCategoryRepository;
use App\Model\Database\Advanced\Repository\ArticleRepository;
use App\Model\Database\Basic\Entity\Book;
use App\Model\Database\Basic\Entity\Category;
use App\Model\Database\Basic\Entity\Tag;
use App\Model\Database\Basic\Repository\BookRepository;
use App\Model\Database\Basic\Repository\CategoryRepository;
use App\Model\Database\Basic\Repository\TagRepository;

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

	public function getArticleRepository(): ArticleRepository
	{
		return $this->getRepository(Article::class);
	}

	public function getArticleCategoryRepository(): ArticleCategoryRepository
	{
		return $this->getRepository(ArticleCategory::class);
	}
}
