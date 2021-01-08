<?php declare(strict_types = 1);

namespace App\Model\Database\Basic\Entity;

use App\Model\Database\Entity\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Nettrine\ORM\Entity\Attributes\Id;

/**
 * @ORM\Entity(repositoryClass="App\Model\Database\Basic\Repository\CategoryRepository")
 */
class Category extends Entity
{

	use Id;

	/** @ORM\Column(type="string") */
	private string $title;

	/**
	 * @var Book[]|Collection
	 * @ORM\OneToMany(targetEntity="Book", mappedBy="category")
	 */
	private Collection $books;

	/**
	 * Category constructor
	 */
	public function __construct()
	{
		$this->books = new ArrayCollection();
	}

	public function getTitle(): string
	{
		return $this->title;
	}

	public function setTitle(string $title): void
	{
		$this->title = $title;
	}

	/**
	 * @return Book[]|Collection
	 */
	public function getBooks(): Collection
	{
		return $this->books;
	}

}
