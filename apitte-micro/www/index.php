<?php declare(strict_types = 1);

use Apitte\Core\Application\IApplication;

// Hack for PHP Built-in Development server!!!
if (php_sapi_name() === 'cli-server') {
	$_SERVER['SCRIPT_NAME'] = '/index.php';
}

$container = require __DIR__ . '/../app/bootstrap.php';

/** @var IApplication $application */
$application = $container->getByType(IApplication::class);
$application->run();
