<?php declare(strict_types=1);

namespace App\Presenters;

use App\Model\Database\Basic\Entity\Book;
use App\Model\Database\Basic\Entity\Category;
use App\Model\Database\Basic\Entity\Tag;
use App\Model\Database\EntityManagerDecorator;
use Nette\Application\UI\Form;
use Nette\Application\UI\Presenter;

class BasicPresenter extends Presenter
{

	/** @var EntityManagerDecorator @inject */
	public $em;

	public function renderDefault(): void
	{
		$bookRepository = $this->em->getBookRepository();
		$categoryRepository = $this->em->getCategoryRepository();
		$tagRepository = $this->em->getTagRepository();

		$this->template->books = $bookRepository->findAll();
		$this->template->categories = $categoryRepository->findAll();
		$this->template->tags = $tagRepository->findAll();
	}

	protected function createComponentBookForm(): Form
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

	public function actionReadBook($id): void
	{
		$bookRepository = $this->em->getBookRepository();

		$book = $bookRepository->getById($id);
		if ($book) {
			/** @var Book $book */
			$book->setAlreadyRead(true);
			$this->em->flush($book);
		}

		$this->redirect('Homepage:');
	}

	public function actionDeleteBook($id): void
	{
		$bookRepository = $this->em->getBookRepository();

		$book = $bookRepository->getById($id);

		if ($book) {
			$this->em->remove($book);
			$this->em->flush();
		}

		$this->redirect('Homepage:');
	}

	public function processBookForm(Form $form): void
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

	protected function createComponentCategoryForm(): Form
	{
		$form = new Form();
		$form->addText('title', 'Title');
		$form->addSubmit('send', 'OK');
		$form->onSubmit[] = [$this, 'processCategoryForm'];
		return $form;
	}

	public function processCategoryForm(Form $form): void
	{
		$values = $form->getValues();
		$category = new Category();
		$category->setTitle($values->title);
		$this->em->persist($category);
		$this->em->flush();
		$this->redirect('this');
	}

	protected function createComponentTagForm(): Form
	{
		$form = new Form();
		$form->addText('title', 'Title');
		$form->addSubmit('send', 'OK');
		$form->onSubmit[] = [$this, 'processTagForm'];
		return $form;
	}

	public function processTagForm(Form $form): void
	{
		$values = $form->getValues();
		$category = new Tag();
		$category->setTitle($values->title);
		$this->em->persist($category);
		$this->em->flush();
		$this->redirect('this');
	}

	protected function createComponentTagAddForm(): Form
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

	public function processTagAddForm(Form $form): void
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
