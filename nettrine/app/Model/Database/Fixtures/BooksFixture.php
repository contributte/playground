<?php declare(strict_types=1);

use App\Model\Database\Entity\Book;
use App\Model\Database\Entity\Category;
use App\Model\Database\Entity\Tag;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class BooksFixture implements FixtureInterface, OrderedFixtureInterface
{

	/**
	 * Load data fixtures with the passed ObjectManager
	 */
	public function load(ObjectManager $manager): void
	{
		$categoryA = new Category();
		$categoryA->setTitle('Book category A');

		$categoryB = new Category();
		$categoryB->setTitle('Book category B');

		$manager->persist($categoryA);
		$manager->persist($categoryB);

		$bookA = new Book();
		$bookA->setTitle('Book title A');
		$bookA->setCategory($categoryA);
		$bookA->setAlreadyRead(FALSE);

		$bookB = new Book();
		$bookB->setTitle('Book title B');
		$bookB->setCategory($categoryA);
		$bookB->setAlreadyRead(TRUE);

		$bookC = new Book();
		$bookC->setTitle('Book title C');
		$bookC->setCategory($categoryB);
		$bookC->setAlreadyRead(FALSE);

		$manager->persist($bookA);
		$manager->persist($bookB);
		$manager->persist($bookC);

		$tagA = new Tag();
		$tagA->setTitle('Book tag A');

		$tagB = new Tag();
		$tagB->setTitle('Book tag B');

		$manager->persist($tagA);
		$manager->persist($tagB);

		$bookA->getTags()->add($tagA);
		$tagA->getBooks()->add($bookA);

		$bookB->getTags()->add($tagA);
		$tagA->getBooks()->add($bookB);

		$manager->flush();
	}

	/**
	 * Get the order of this fixture
	 */
	public function getOrder(): int
	{
		return 1;
	}

}
