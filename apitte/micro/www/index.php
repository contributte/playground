<?php declare(strict_types = 1);

// Hack for PHP Built-in Development server!!!
if (php_sapi_name() === 'cli-server') {
	$_SERVER['SCRIPT_NAME'] = '/index.php';
}

$container = require __DIR__ . '/../app/bootstrap.php';

/** @var Apitte\Core\Dispatcher\IDispatcher $dispatcher */
$dispatcher = $container->getByType(Apitte\Core\Dispatcher\IDispatcher::class);

// Dispatch controller
$response = $dispatcher->dispatch(
	Contributte\Psr7\Psr7ServerRequestFactory::fromSuperGlobal(),
	Contributte\Psr7\Psr7ResponseFactory::fromGlobal()
);

// Send response
(new Contributte\Psr7\App\Micro())->send($response);
