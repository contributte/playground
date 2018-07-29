<?php declare(strict_types = 1);

namespace App\Presenters;

use App\Events\ExampleEvent;
use Nette\Application\UI\Presenter;
use Symfony\Component\EventDispatcher\EventDispatcher;

class HomepagePresenter extends Presenter
{

	/** @var EventDispatcher */
	private $dispatcher;

	public function __construct(EventDispatcher $dispatcher)
	{
		parent::__construct();
		$this->dispatcher = $dispatcher;
	}

	public function actionDefault(): void
	{
		$this->dispatcher->dispatch(ExampleEvent::NAME, new ExampleEvent('example'));
	}

}
