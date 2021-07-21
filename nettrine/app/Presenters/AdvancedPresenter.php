<?php declare(strict_types = 1);

namespace App\Presenters;

use App\Model\Database\Advanced\Entity\Article;
use App\Model\Database\Advanced\Entity\ArticleCategory;
use App\Model\Database\EntityManagerDecorator;
use Doctrine\Common\Collections\Criteria;
use Gedmo\Loggable\Entity\LogEntry;
use Gedmo\Loggable\Entity\Repository\LogEntryRepository;
use Nette\Application\UI\Form;
use Nette\Application\UI\Presenter;
use Nette\Localization\ITranslator;
use Throwable;

class AdvancedPresenter extends Presenter
{

	/** @inject */
	public EntityManagerDecorator $em;

	/** @inject */
	public ITranslator $translator;

	/** @persistent */
	public string $locale = '';

	public function renderDefault(string $locale): void
	{
		$articleCategoryRepository = $this->em->getArticleCategoryRepository();
		$articleRepository = $this->em->getArticleRepository();

		$this->template->categories = $articleCategoryRepository->findAllOrderedCategories();

		$articles = [];

		$criteria = new Criteria();
		$criteria->where(Criteria::expr()->isNull('deletedAt'));

		foreach ($articleRepository->matching($criteria) as $article) {
			/** @var Article $article */
			$article->setTranslatableLocale($locale);
			$this->em->refresh($article);

			$articles[] = $article;
		}

		$this->template->articles = $articles;

		$articlesHistory = [];
		foreach ($articles as $article) {
			/** @var LogEntryRepository $repo */
			$repo = $this->em->getRepository(LogEntry::class); // we use default log entry class
			$logs = $repo->getLogEntries($article);

			foreach ($logs as $log) {
				/** @var LogEntry $log */
				$articlesHistory[$log->getId()]['article'] = $article;
				$articlesHistory[$log->getId()]['history'] = $log;
			}
		}

		ksort($articlesHistory);

		$this->template->articlesHistory = $articlesHistory;
	}

	protected function createComponentAddArticleCategoryForm(): Form
	{
		$form = new Form();

		$form->addText('title', 'messages.article_categories.title')
			->setRequired('messages.article_categories.title_required');

		$categories = $this->em->getArticleCategoryRepository()->findPairs();
		$form->addSelect('parent', 'messages.article_categories.parent_category', $categories)
			->setTranslator(null);

		$form->addSubmit('send', 'messages.articles.submit');

		$form->setTranslator($this->translator);

		$form->onSuccess[] = [$this, 'processAddArticleCategoryForm'];

		return $form;
	}

	public function processAddArticleCategoryForm(Form $form): void
	{
		$values = $form->getValues();

		$this->em->beginTransaction();

		$category = new ArticleCategory();
		$category->setTitle($values->title);

		$articleCategoryRepository = $this->em->getArticleCategoryRepository();

		/** @var ArticleCategory $parent */
		$parent = $articleCategoryRepository->find($values->parent);
		$category->setParent($parent);

		$this->em->persist($category);
		$this->em->flush();

		$this->em->commit();

		$this->redirect('this');
	}

	protected function createComponentAddArticleForm(): Form
	{
		$form = new Form();

		$form->addText('enTitle', 'messages.articles.enTitle')
			->setRequired('messages.articles.enTitle_required');
		$form->addTextArea('enContent', 'messages.articles.enContent')
			->setRequired('messages.articles.enContent_required');

		$form->addText('czTitle', 'messages.articles.czTitle')
			->setRequired('messages.articles.czTitle_required');
		$form->addTextArea('czContent', 'messages.articles.czContent')
			->setRequired('messages.articles.czContent_required');

		$form->addSubmit('send', 'messages.articles.submit');

		$form->setTranslator($this->translator);

		$form->onSuccess[] = [$this, 'processAddArticleForm'];

		return $form;
	}

	public function processAddArticleForm(Form $form): void
	{
		$values = $form->getValues();

		$article = new Article();
		$article->setTranslatableLocale('en_GB');
		$article->setTitle($values->enTitle);
		$article->setContent($values->enContent);

		$this->em->persist($article);
		$this->em->flush();

		$article->setTranslatableLocale('cs_CZ');
		$article->setTitle($values->czTitle);
		$article->setContent($values->czContent);

		$this->em->persist($article);
		$this->em->flush();

		$this->redirect('this');
	}

	public function actionDeleteArticle(int $id): void
	{
		$articleRepository = $this->em->getArticleRepository();
		$article = $articleRepository->find($id);

		if ($article instanceof Article) {
			$this->em->remove($article);
			$this->em->flush();

			$this->flashMessage($this->translator->translate('messages.articles.success_delete'));
		}

		$this->redirect('Advanced:');
	}

	public function actionDeleteCategory(int $id): void
	{
		try {
			$this->em->beginTransaction();
			$articleCategoryRepository = $this->em->getArticleCategoryRepository();
			$category = $articleCategoryRepository->find($id);

			if ($category instanceof ArticleCategory) {
				$this->em->remove($category);
				$this->em->flush();

				$this->em->commit();

				$this->flashMessage($this->translator->translate('messages.categories.success_delete'));
			}
		} catch (Throwable $e) {
			$this->em->rollback();
			$this->flashMessage($e->getMessage());
		}

		$this->redirect('Advanced:');
	}

}
