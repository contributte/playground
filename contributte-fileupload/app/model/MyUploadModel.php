<?php

namespace App\Model;

use Nette\DI\Container;
use Nette\Http\FileUpload;

class MyUploadModel implements \Zet\FileUpload\Model\IUploadModel
{

	/** @var Container */
	private $container;

	public function __construct(Container $container)
	{
		$this->container = $container;
	}

	/**
	 * @inheritDoc
	 */
	public function save(FileUpload $file, array $params = [])
	{
		bdump($file);
		bdump($params);
		$wwwDir = $this->container->getParameters()['wwwDir'];
		$filePath = $wwwDir . '/uploaded/' . $file->name;
		$file->move($filePath);

		return $filePath;
	}

	/**
	 * @inheritDoc
	 */
	public function rename($upload, $newName)
	{
		bdump($upload);
		bdump($newName);
	}

	/**
	 * @inheritDoc
	 */
	public function remove($uploaded): void
	{
		bdump($uploaded);
		unlink($uploaded);
	}
}
