<?php declare(strict_types=1);

namespace App\Model\Service;

use Doctrine\Common\EventSubscriber;
use Doctrine\DBAL\Event\ConnectionEventArgs;
use Doctrine\DBAL\Events;
use LengthException;

/**
 * Naive implementation of library limiter that checks the size of book library
 * and throws exception if the limit is exceeded
 *
 * @package App\Model\Service
 */
final class LibraryLimiter implements EventSubscriber
{

	/**
	 * Maximum number of books to be stored in DB
	 */
	public const LIBRARY_MAX_SIZE = 10;

	/**
	 * Returns an array of events this subscriber wants to listen to.
	 *
	 * @return array<string>
	 */
	public function getSubscribedEvents(): array
	{
		return [Events::postConnect];
	}

	public function postConnect(ConnectionEventArgs $args): void
	{
		$schemaManager = $args->getConnection()->getSchemaManager();

		if ($schemaManager->tablesExist(array('book')) == TRUE) {
			$all = $args->getConnection()->fetchAll("SELECT id FROM book");

			if (count($all) > self::LIBRARY_MAX_SIZE) {
				throw new LengthException('Oops. Too many books were placed in such a small library and it collapsed.');
			}
		}
	}

}
