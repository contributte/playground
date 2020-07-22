<?php declare(strict_types=1);

namespace App\Presenters;

use App\Model\Database\Basic\Entity\Book;
use App\Model\Database\Basic\Entity\Category;
use App\Model\Database\EntityManagerDecorator;
use App\Model\Database\Translatable\Entity\Article;
use Gedmo\Loggable\Entity\LogEntry;
use Nette\Application\UI\Form;
use Nette\Application\UI\Presenter;

class DoctrineExtensionsPresenter extends Presenter
{

	/** @var EntityManagerDecorator @inject */
	public $em;

	public function renderDefault(): void
	{
		$articleRepository = $this->em->getArticleRepository();
		$articlesEN = [];

		foreach ($articleRepository->findAll() as $article) {
			$article->setTranslatableLocale('en_GB');
			$this->em->refresh($article);

			$articlesEN[] = $article;
		}

		$this->template->articlesEN = $articlesEN;

		//reset for another uses
		$this->em->clear();

		$articlesCZ = [];

		foreach ($articleRepository->findAll() as $article) {
			$article->setTranslatableLocale('cs_CZ');
			$this->em->refresh($article);

			$articlesCZ[] = $article;
		}

		$this->template->articlesCZ = $articlesCZ;

		$articlesHistory = [];
		foreach ($articlesCZ as $article) {
			$repo = $this->em->getRepository(LogEntry::class); // we use default log entry class
			$logs = $repo->getLogEntries($article);

			foreach ($logs as $id => $log) {
				$articlesHistory[$id]['article'] = $article;
				$articlesHistory[$id]['history'] = $log;
			}
		}

		$this->template->articlesHistory = $articlesHistory;
	}

	protected function createComponentAddArticleForm(string $name): Form
	{
		$form = new Form();

		$form->addText('enTitle', 'Article title in English')
			->setRequired();
		$form->addTextArea('enContent', 'Article content in English')
			->setRequired();

		$form->addText('czTitle', 'Nadpis článku česky')
			->setRequired();
		$form->addTextArea('czContent', 'Obsah článku česky')
			->setRequired();

		$form->addSubmit('send', 'OK');
		$form->onSubmit[] = [$this, 'processAddArticleForm'];

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
}
