<?php declare(strict_types=1);

use App\Model\Database\Advanced\Entity\Article;
use App\Model\Database\Advanced\Entity\ArticleCategory;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ArticlesFixture implements FixtureInterface, OrderedFixtureInterface
{

	/**
	 * Load data fixtures with the passed ObjectManager
	 */
	public function load(ObjectManager $manager): void
	{
		$categoryRoot = new ArticleCategory();
		$categoryRoot->setTitle('Category root');

		$categoryA = new ArticleCategory();
		$categoryA->setTitle('Category A');
		$categoryA->setParent($categoryRoot);

		$categoryB = new ArticleCategory();
		$categoryB->setTitle('Category B');
		$categoryB->setParent($categoryRoot);

		$categoryAB = new ArticleCategory();
		$categoryAB->setTitle('Category AB');
		$categoryAB->setParent($categoryA);

		$manager->persist($categoryRoot);
		$manager->persist($categoryA);
		$manager->persist($categoryB);
		$manager->persist($categoryAB);

		$manager->flush();

		$article = new Article();

		$article->setTitle('Nadpis v češtině');
		$article->setContent("Text v češtině");
		$article->setTranslatableLocale('cs_CZ');
		$article->setCategory($categoryA);

		$manager->persist($article);
		$manager->flush();

		$article->setTitle('Title in English');
		$article->setContent("Content in English");
		$article->setTranslatableLocale('en_GB');

		$manager->persist($article);
		$manager->flush();
	}

	/**
	 * Get the order of this fixture
	 */
	public function getOrder(): int
	{
		return 2;
	}

}
