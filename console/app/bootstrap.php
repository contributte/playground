<?php declare(strict_types = 1);

use Contributte\Bootstrap\ExtraConfigurator;

require __DIR__ . '/../vendor/autoload.php';

$configurator = new ExtraConfigurator();

//$configurator->setDebugMode('23.75.345.200'); // enable for your remote IP
$configurator->enableTracy(__DIR__ . '/../log');

$configurator->setTimeZone('Europe/Prague');
$configurator->setTempDirectory(__DIR__ . '/../temp');

$configurator->addConfig(__DIR__ . '/config/config.neon');
if (PHP_SAPI === 'cli') {
	// include console and console commands only if application is accessed through console
	$configurator->addConfig(__DIR__ . '/config/config.console.neon');
}

$container = $configurator->createContainer();

return $container;
