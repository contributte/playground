<?php declare(strict_types=1);

namespace App\Model\Database\Advanced\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Translatable;

/**
 * @ORM\Table(name="articles")
 * @ORM\Entity(repositoryClass="App\Model\Database\Advanced\Repository\ArticleRepository")
 * @Gedmo\Loggable
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=true)
 */
class Article implements Translatable
{
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @Gedmo\Translatable
	 * @Gedmo\Versioned
	 * @ORM\Column(name="title", type="string", length=128)
	 */
	private $title;

	/**
	 * @Gedmo\Translatable
	 * @Gedmo\Versioned
	 * @ORM\Column(name="content", type="text")
	 */
	private $content;

	/**
	 * @Gedmo\Locale
	 * Used locale to override Translation listener`s locale
	 * this is not a mapped field of entity metadata, just a simple property
	 */
	private $locale;

	/**
	 * @ORM\Column(name="deletedAt", type="datetime", nullable=true)
	 */
	private $deletedAt;

	public function getId()
	{
		return $this->id;
	}

	public function setTitle($title)
	{
		$this->title = $title;
	}

	public function getTitle()
	{
		return $this->title;
	}

	public function setContent($content)
	{
		$this->content = $content;
	}

	public function getContent()
	{
		return $this->content;
	}

	public function setTranslatableLocale($locale)
	{
		$this->locale = $locale;
	}

	public function getDeletedAt()
	{
		return $this->deletedAt;
	}

	public function setDeletedAt($deletedAt)
	{
		$this->deletedAt = $deletedAt;
	}
}
