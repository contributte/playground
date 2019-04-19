<?php declare(strict_types = 1);

namespace App\Events;

use Symfony\Component\EventDispatcher\Event;

class ExampleEvent extends Event
{

	public const NAME = 'app.events.exampleEvent';

	/** @var string */
	private $example;

	public function __construct(string $example)
	{
		$this->example = $example;
	}

	public function getExample(): string
	{
		return $this->example;
	}

}
