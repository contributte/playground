<?php

declare(strict_types=1);

namespace App\Model\Database\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Nettrine\ORM\Entity\Attributes\Id;

/**
 * @ORM\Entity(repositoryClass="App\Model\Database\Repository\CategoryRepository")
 */
class Category extends Entity
{

	use Id;

	/**
	 * @ORM\Column(type="string")
	 * @var string
	 */
	private $title;

	/**
	 * @var Book[]|Collection
	 * @ORM\OneToMany(targetEntity="Book", mappedBy="category")
	 */
	private $books;

	/**
	 * Category constructor
	 */
	public function __construct()
	{
		$this->books = new ArrayCollection();
	}

	/**
	 * @return string
	 */
	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * @param string $title
	 */
	public function setTitle($title)
	{
		$this->title = $title;
	}

	/**
	 * @return Book[]|Collection
	 */
	public function getBooks()
	{
		return $this->books;
	}


}
