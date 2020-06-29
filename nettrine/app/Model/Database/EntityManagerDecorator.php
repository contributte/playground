<?php declare(strict_types=1);

namespace App\Model\Database;

use Nettrine\ORM\EntityManagerDecorator as NettrineEntityManagerDecorator;

/**
 * Custom EntityManagerDecorator
 */
final class EntityManagerDecorator extends NettrineEntityManagerDecorator
{

	use TRepositories;
}
