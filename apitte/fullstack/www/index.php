<?php declare(strict_types = 1);

// Hack for PHP Built-in Development server!!!
if (php_sapi_name() === 'cli-server') {
	$_SERVER['SCRIPT_NAME'] = '/index.php';
}

//$_SERVER['RE'];

$container = require __DIR__ . '/../app/bootstrap.php';
$container->getByType(Contributte\Middlewares\Application\IApplication::class)->run();
