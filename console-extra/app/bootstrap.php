<?php declare(strict_types = 1);

use Nette\Configurator;

require __DIR__ . '/../vendor/autoload.php';

$configurator = new Configurator;

$configurator->setDebugMode(true);
$configurator->enableTracy(__DIR__ . '/../log');

$configurator->setTimeZone('Europe/Prague');
$configurator->setTempDirectory(__DIR__ . '/../temp');

$configurator->addConfig(__DIR__ . '/config/config.neon');
if (PHP_SAPI === 'cli') {
	// include console and console commands only if application is accessed through console
	$configurator->addConfig(__DIR__ . '/config/config.console.neon');
}

return $configurator->createContainer();
