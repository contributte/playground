<?php

namespace App\Presenters;

use App\Model\Database\Entity\Book;
use App\Model\Database\Entity\Category;
use App\Model\Database\Entity\Tag;
use App\Model\Database\EntityManager;
use Nette\Application\UI\Form;
use Nette\Application\UI\Presenter;

class HomepagePresenter extends Presenter
{

	/** @var EntityManager @inject */
	public $em;

	/**
	 * @return void
	 */
	public function renderDefault()
	{
		$bookRepository = $this->em->getBookRepository();
		$categoryRepository = $this->em->getCategoryRepository();
		$tagRepository = $this->em->getTagRepository();

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

		$categoryRepository = $this->em->getCategoryRepository();
		$categories = $categoryRepository->findPairs('title');

		$form->addSelect('category', 'Category', $categories);
		$form->addSubmit('send', 'OK');

		$form->onSubmit[] = [$this, 'processBookForm'];
		return $form;
	}

	public function actionReadBook($id)
	{
		$bookRepository = $this->em->getBookRepository();

		$book = $bookRepository->getById($id);
		if ($book) {
			/** @var Book $book */
			$book->setAlreadyRead(TRUE);
			$this->em->flush($book);
		}

		$this->redirect('Homepage:');
	}

	public function actionDeleteBook($id)
	{
		$bookRepository = $this->em->getBookRepository();

		$book = $bookRepository->getById($id);

		if ($book) {
			$this->em->remove($book);
			$this->em->flush();
		}

		$this->redirect('Homepage:');
	}

	public function processBookForm(Form $form)
	{
		$values = $form->getValues();

		$categoryRepository = $this->em->getCategoryRepository();
		/** @var Category $category */
		$category = $categoryRepository->find($values->category);

		$book = new Book();
		$book->setTitle($values->title);
		$book->setCategory($category);
		$this->em->persist($book);
		$this->em->flush();
		$this->redirect('this');
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
		$category = new Category();
		$category->setTitle($values->title);
		$this->em->persist($category);
		$this->em->flush();
		$this->redirect('this');
	}

	protected function createComponentTagForm()
	{
		$form = new Form();
		$form->addText('title', 'Title');
		$form->addSubmit('send', 'OK');
		$form->onSubmit[] = [$this, 'processTagForm'];
		return $form;
	}

	public function processTagForm(Form $form)
	{
		$values = $form->getValues();
		$category = new Tag();
		$category->setTitle($values->title);
		$this->em->persist($category);
		$this->em->flush();
		$this->redirect('this');
	}

	protected function createComponentTagAddForm()
	{
		$form = new Form();

		$tagRepository = $this->em->getTagRepository();
		$bookRepository = $this->em->getBookRepository();

		$tags = $tagRepository->findPairs('title');
		$books = $bookRepository->findPairs('title');

		$form->addSelect('tag', 'Tag', $tags);
		$form->addSelect('book', 'Book', $books);
		$form->addSubmit('send', 'OK');
		$form->onSubmit[] = [$this, 'processTagAddForm'];

		return $form;
	}

	public function processTagAddForm(Form $form)
	{
		$values = $form->getValues();

		$bookRepository = $this->em->getBookRepository();
		$tagRepository = $this->em->getTagRepository();

		/** @var Book $book */
		$book = $bookRepository->find($values->book);
		/** @var Tag $tag */
		$tag = $tagRepository->find($values->tag);

		$book->getTags()->add($tag);
		$tag->getBooks()->add($book);

		$this->em->flush();
		$this->redirect('this');
	}

}
