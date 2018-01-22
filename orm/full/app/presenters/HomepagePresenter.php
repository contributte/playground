<?php

namespace App\Presenters;

use App\Model\Database\Entity\Book;
use App\Model\Database\Entity\Category;
use App\Model\Database\Entity\Tag;
use App\Model\Database\Repository\BookRepository;
use App\Model\Database\Repository\CategoryRepository;
use App\Model\Database\Repository\TagRepository;
use Nette\Application\UI\Presenter;
use Nette\Forms\Form;
use Nettrine\ORM\EntityManager;

class HomepagePresenter extends Presenter
{

	/** @var EntityManager @inject */
	public $em;

	/**
	 * @return void
	 */
	public function renderDefault()
	{
		//		 Criteria
		//		$criteria = Criteria::create()
		//			->where(Criteria::expr()->eq('id', 1));
		//
		//		dump($tagRepository->matching($criteria)->first());

		/** @var BookRepository $bookRepository */
		$bookRepository = $this->em->getRepository(Book::class);
		/** @var CategoryRepository $categoryRepository */
		$categoryRepository = $this->em->getRepository(Category::class);
		/** @var TagRepository $tagRepository */
		$tagRepository = $this->em->getRepository(Tag::class);

		$this->template->books = $bookRepository->findAll();
		$this->template->categories = $categoryRepository->findAll();
		$this->template->tags = $tagRepository->findAll();
	}

	/**
	 * @return Form
	 */
	protected function createComponentBookForm()
	{
		$form = new Form();
		$form->addText('title', 'Title');

		$categories = $this->findPairs(Category::class, 'title');

		$form->addSelect('category', 'Category', $categories);
		$form->addSubmit('send', 'OK');
		return $form;
	}

	protected function createComponentCategoryForm()
	{
		$form = new Form();
		$form->addText('title', 'Title');
		$form->addSubmit('send', 'OK');
		$form->onSubmit[] = [$this, 'processCategoryForm'];
		return $form;
	}

	public function processCategoryForm(Form $form)
	{
		$values = $form->getValues();
		dump($values);
		exit;

		$category = new Category();
		$category->setTitle($values->title);
		$this->em->persist($category);
		$this->em->flush();
		$this->redirect('Homepage:');
	}

	protected function createComponentTagForm()
	{
		$form = new Form();
		$form->addText('title', 'Title');
		$form->addSubmit('send', 'OK');
		return $form;
	}

	protected function createComponentTagAddForm()
	{
		$form = new Form();

		$tags = $this->findPairs(Tag::class, 'title');
		$books = $this->findPairs(Book::class, 'title');

		$form->addSelect('tag', 'Tag', $tags);
		$form->addSelect('book', 'Book', $books);
		$form->addSubmit('send', 'OK');
		return $form;
	}

	private function findPairs($entity, $value, $key = 'id')
	{
		// Find pairs
		$select = [];
		$categories = $this->em->createQueryBuilder()
			->select('e.' . $key, 'e.' . $value)
			->from($entity, 'e')
			->getQuery()
			->getArrayResult();
		foreach ($categories as $category) {
			$select[$category[$key]] = $category[$value];
		}

		return $select;
	}
}
