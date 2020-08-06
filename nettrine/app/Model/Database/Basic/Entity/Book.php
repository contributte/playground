<?php declare(strict_types=1);

namespace App\Model\Database\Basic\Entity;

use App\Model\Database\Entity\Entity;
use DateTime;
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
	 */
	private string $title;

	/**
	 * @ORM\Column(type="boolean")
	 */
	private bool $alreadyRead = FALSE;

	/**
	 * @ORM\Column(type="string")
	 */
	private syting $createdAt;

	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	private string $updatedAt;

	/**
	 * @ORM\ManyToOne(targetEntity="Category", inversedBy="books")
	 * @ORM\JoinColumn(nullable=FALSE)
	 */
	private Category $category;

	/**
	 * @var Tag[]|Collection
	 * @ORM\ManyToMany(targetEntity="Tag", mappedBy="books")
	 */
	private Collection $tags;

	/**
	 * @param Book constructor
	 */
	public function __construct()
	{
		$this->tags = new ArrayCollection();
	}

	public function getTitle(): string
	{
		return $this->title;
	}

	public function setTitle($title): string
	{
		$this->title = $title;
	}

	public function isAlreadyRead(): bool
	{
		return $this->alreadyRead;
	}

	public function setAlreadyRead(bool $read): void
	{
		$this->alreadyRead = $read;
	}

	public function getCategory(): Category
	{
		return $this->category;
	}

	public function setCategory(Category $category): void
	{
		$this->category = $category;
	}

	/**
	 * @return Tag[]|Collection
	 */
	public function getTags(): Collection
	{
		return $this->tags;
	}

	public function getCreatedAt(): DateTime
	{
		return $this->createdAt;
	}

	public function getUpdatedAt(): DateTime
	{
		return $this->updatedAt;
	}

	/**
	 * @ORM\PrePersist
	 */
	public function onPrePersist()
	{
		$this->createdAt = $this->getCurrentDate();

		if ($this->id !== NULL) {
			throw new LogicException("Entity id field should be null during prePersistEvent");
		}
	}

	/**
	 * @ORM\PostPersist()
	 */
	public function onPostPersist(LifecycleEventArgs $args)
	{
		// $args->getEntity() and $this are pointers to the same objects
		if ($args->getEntity()->getId() === NULL) {
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
		 *      - event will be fired when user clicks [delete] link
		 *      - we could possibly prevent deleting in this event by throwing exception etc.
		 *      - we can also use $args->getEntityManager()
		 */
	}

}
