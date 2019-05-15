<?php

use Contributte\Nextras\Orm\Generator\Analyser\Database\DatabaseAnalyser;
use Contributte\Nextras\Orm\Generator\SimpleFactory;
use Contributte\Nextras\Orm\Generator\Config\Impl\SeparateConfig;

require_once __DIR__ . '/vendor/autoload.php';

$factory = new SimpleFactory(
    new SeparateConfig(['output' => __DIR__ . '/model/separate']),
    new DatabaseAnalyser('mysql:host=127.0.0.1;dbname=nextras_orm_generator', 'root')
);

$factory->create()->generate();
