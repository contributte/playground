<?php declare(strict_types=1);

namespace App\Model\Database\Basic\Entity;

use App\Model\Database\Entity\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping as ORM;
use LogicException;
use Nettrine\ORM\Entity\Attributes\Id;

/**
 * @ORM\Entity(repositoryClass="App\Model\Database\Basic\Repository\BookRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Book extends Entity
{

	use Id;

	/**
	 * @ORM\Column(type="string")
	 * @var string
	 */
	private $title;

	/**
	 * @ORM\Column(type="boolean")
	 * @var bool
	 */
	private $alreadyRead = false;

	/**
	 * @ORM\Column(type="string")
	 * @var string
	 */
	private $createdAt;

	/**
	 * @ORM\Column(type="string", nullable=true)
	 * @var string
	 */
	private $updatedAt;

	/**
	 * @var Category
	 * @ORM\ManyToOne(targetEntity="Category", inversedBy="books")
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
	 * @return bool
	 */
	public function isAlreadyRead()
	{
		return $this->alreadyRead;
	}

	/**
	 * @param bool $read
	 */
	public function setAlreadyRead($read)
	{
		$this->alreadyRead = $read;
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

	/**
	 * @return string
	 */
	public function getCreatedAt()
	{
		return $this->createdAt;
	}

	/**
	 * @return string
	 */
	public function getUpdatedAt()
	{
		return $this->updatedAt;
	}

	/**
	 * @ORM\PrePersist
	 *
	 */
	public function onPrePersist()
	{
		$this->createdAt = $this->getCurrentDate();

		if ($this->id !== null) {
			throw new LogicException("Entity id field should be null during prePersistEvent");
		}
	}

	/**
	 * @ORM\PostPersist()
	 * @param LifecycleEventArgs $args
	 */
	public function onPostPersist(LifecycleEventArgs $args)
	{
		// $args->getEntity() and $this are pointers to the same objects
		if ($args->getEntity()->getId() === null) {
			throw new LogicException("Entity id field should be already filled during prePersistEvent");
		}
	}

	/**
	 * @ORM\PreUpdate()
	 */
	public function onPreUpdate()
	{
		$this->updatedAt = $this->getCurrentDate();
	}

	/**
	 * @ORM\PreRemove()
	 * @param LifecycleEventArgs $args
	 */
	public function onPreRemove(LifecycleEventArgs $args)
	{
		/*
		 * Note - remove will call SQL delete command that removes the record from DB
		 * 		- event will be fired when user clicks [delete] link
		 * 		- we could possibly prevent deleting in this event by throwing exception etc.
		 * 		- we can also use $args->getEntityManager()
		 */
	}

}
