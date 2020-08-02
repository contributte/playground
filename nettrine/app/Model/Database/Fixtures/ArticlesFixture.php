<?php declare(strict_types=1);

use App\Model\Database\Advanced\Entity\Article;
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
		$article = new Article();

		$article->setTitle('Nadpis v češtině');
		$article->setContent("Text v češtině");
		$article->setTranslatableLocale('cs_CZ');

		$manager->persist($article);
		$manager->flush();

		$article->setTitle('Title in English');
		$article->setContent("Content in English");
		$article->setTranslatableLocale('en_GB');

		$manager->persist($article);
		$manager->flush();;
	}

	/**
	 * Get the order of this fixture
	 */
	public function getOrder(): int
	{
		return 2;
	}

}
