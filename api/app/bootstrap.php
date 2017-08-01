<?php

require __DIR__ . '/../../../api/vendor/autoload.php';
require __DIR__ . '/../../../middlewares/vendor/autoload.php';
require __DIR__ . '/../../../psr7-http-message/vendor/autoload.php';
require __DIR__ . '/../vendor/autoload.php';

$configurator = new Nette\Configurator;

$configurator->setDebugMode(TRUE);
$configurator->enableDebugger(__DIR__ . '/../log');

$configurator->setTimeZone('Europe/Prague');
$configurator->setTempDirectory(__DIR__ . '/../temp');

$configurator->createRobotLoader()
	->addDirectory(__DIR__)
	->register();

$configurator->addConfig(__DIR__ . '/config/config.neon');

$container = $configurator->createContainer();

return $container;
