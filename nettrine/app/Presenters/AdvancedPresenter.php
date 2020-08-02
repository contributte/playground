<?php declare(strict_types=1);

namespace App\Presenters;

use App\Model\Database\EntityManagerDecorator;
use App\Model\Database\Advanced\Entity\Article;
use App\Model\Database\Advanced\Repository\ArticleRepository;
use Gedmo\Loggable\Entity\LogEntry;
use Nette\Application\UI\Form;
use Nette\Application\UI\Presenter;
use Nette\Localization\ITranslator;

class AdvancedPresenter extends Presenter
{

	/** @var EntityManagerDecorator */
	public $em;

	/** @var ArticleRepository */
	public $articleRepository;

	/** @var ITranslator @inject */
	public $translator;

	/** @persistent */
	public $locale;

	public function __construct(EntityManagerDecorator $em)
	{
		parent::__construct();
		$this->em = $em;
		$this->articleRepository = $em->getRepository(Article::class);
	}

	public function renderDefault($locale): void
	{
		if (!$locale) {
			$this->redirect('Advanced:', ['locale' => 'en_GB']);
		}

		$articles = [];

		foreach ($this->articleRepository->findAll() as $article) {
			$article->setTranslatableLocale($locale);
			$this->em->refresh($article);

			$articles[] = $article;
		}

		$this->template->articles = $articles;

		$articlesHistory = [];
		foreach ($articles as $article) {
			$repo = $this->em->getRepository(LogEntry::class); // we use default log entry class
			$logs = $repo->getLogEntries($article);

			foreach ($logs as $log) {
				$articlesHistory[$log->getId()]['article'] = $article;
				$articlesHistory[$log->getId()]['history'] = $log;
			}
		}

		ksort($articlesHistory);

		$this->template->articlesHistory = $articlesHistory;

		//reset for another uses
		$this->em->clear();
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

	public function actionDelete($id)
	{
		$article = $this->articleRepository->find($id);

		$this->em->remove($article);
		$this->em->flush();

		$this->flashMessage($this->translator->translate('messages.articles.success_delete'));
		$this->redirect('Advanced:');
	}
}
