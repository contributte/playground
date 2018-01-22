<?php

namespace App\Model\Database\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Model\Database\Repository\BookRepository")
 */
class Book
{

	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue
	 * @var int
	 */
	private $id;

	/**
	 * @ORM\Column(type="string")
	 * @var string
	 */
	private $title;

	/**
	 * @var Category
	 * @ORM\ManyToOne(targetEntity="Category", inversedBy="category")
	 * @ORM\JoinColumn(nullable=FALSE)
	 */
	private $category;

	/**
	 * @var Tag[]|Collection
	 * @ORM\ManyToMany(targetEntity="Tag", mappedBy="books")
	 */
	private $tags;

	/**
	 * @param Book constructor
	 */
	public function __construct()
	{
		$this->tags = new ArrayCollection();
	}

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
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
	 * @return Category
	 */
	public function getCategory()
	{
		return $this->category;
	}

	/**
	 * @param Category $category
	 */
	public function setCategory(Category $category)
	{
		$this->category = $category;
	}

	/**
	 * @return Tag[]|Collection
	 */
	public function getTags()
	{
		return $this->tags;
	}

}
