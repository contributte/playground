<?php declare(strict_types = 1);

namespace App\Events;

use Contributte\Events\Extra\Event\Application\ApplicationEvents;
use Contributte\Events\Extra\Event\Application\PresenterEvent;
use Contributte\Events\Extra\Event\Application\PresenterShutdownEvent;
use Contributte\Events\Extra\Event\Application\PresenterStartupEvent;
use Contributte\Events\Extra\Event\Application\RequestEvent;
use Contributte\Events\Extra\Event\Application\ResponseEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ExampleSubscriber implements EventSubscriberInterface
{

	public static function getSubscribedEvents(): array
	{
		return [
			ExampleEvent::NAME => 'example',
			ApplicationEvents::ON_PRESENTER => 'presenter',
			ApplicationEvents::ON_PRESENTER_STARTUP => 'presenterStartup',
			ApplicationEvents::ON_PRESENTER_SHUTDOWN => 'presenterShutdown',
			ApplicationEvents::ON_REQUEST => 'request',
			ApplicationEvents::ON_RESPONSE => 'response',
		];
	}

	public function example(ExampleEvent $event): void
	{
		bdump($event->getExample(), 'Example');
	}

	public function presenter(PresenterEvent $event): void
	{
		bdump($event->getPresenter(), 'Presenter');
	}

	public function presenterStartup(PresenterStartupEvent $event): void
	{
		bdump($event->getPresenter(), 'Presenter startup');
	}

	public function presenterShutdown(PresenterShutdownEvent $event): void
	{
		bdump($event->getPresenter(), 'Presenter shutdown');
	}

	public function request(RequestEvent $event): void
	{
		bdump($event->getRequest(), 'Request');
	}

	public function response(ResponseEvent $event): void
	{
		bdump($event->getResponse(), 'Response');
	}
}
