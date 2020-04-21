<?php

declare(strict_types=1);

namespace App;

use Nette\Configurator;

final class Bootstrap
{

	public static function boot(): Configurator
	{
		$configurator = new Configurator;

		$configurator->enableTracy(__DIR__ . '/../log');

		$configurator->setTimeZone('Europe/Prague');
		$configurator->setTempDirectory(__DIR__ . '/../temp');

		$configurator->addConfig(__DIR__ . '/config/common.neon');

		if (file_exists(__DIR__ . '/config/local.neon')) {
			$configurator->addConfig(__DIR__ . '/config/local.neon');
		}

		return $configurator;
	}
}
