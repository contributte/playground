<?php declare(strict_types=1);

namespace App\Model\Database\Advanced\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;

/**
 * @ORM\Table
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
	private int $id;

	/**
	 * @ORM\ManyToOne(targetEntity="ArticleCategory", inversedBy="articles")
	 * @ORM\JoinColumn(name="category_id", referencedColumnName="id", onDelete="CASCADE")
	 */
	private ?ArticleCategory $category;

	/**
	 * @Gedmo\Translatable
	 * @Gedmo\Versioned
	 * @ORM\Column(name="title", type="string", length=128)
	 */
	private string $title;

	/**
	 * @Gedmo\Slug(fields={"title"})
	 * @ORM\Column(length=128, unique=true)
	 */
	private string $slug;

	/**
	 * @Gedmo\Translatable
	 * @Gedmo\Versioned
	 * @ORM\Column(name="content", type="text")
	 */
	private string $content;

	/**
	 * @Gedmo\Locale
	 * Used locale to override Translation listener`s locale
	 * this is not a mapped field of entity metadata, just a simple property
	 */
	private ?string $locale = NULL;

	/**
	 * @var \DateTime $created
	 *
	 * @Gedmo\Timestampable(on="create")
	 * @ORM\Column(type="datetime")
	 */
	private DateTime $created;

	/**
	 * @Gedmo\Timestampable(on="update")
	 * @ORM\Column(type="datetime")
	 */
	private DateTime $updated;

	/**
	 * @ORM\Column(name="content_changed", type="datetime", nullable=true)
	 * @Gedmo\Timestampable(on="change", field={"title", "content"})
	 */
	private ?DateTime $contentChanged;

	/**
	 * @ORM\Column(name="deletedAt", type="datetime", nullable=true)
	 */
	private ?DateTime $deletedAt;

	public function getId(): int
	{
		return $this->id;
	}

	public function getCategory(): ArticleCategory
	{
		return $this->category;
	}

	public function getTitle(): string
	{
		return $this->title;
	}

	public function getSlug(): string
	{
		return $this->slug;
	}

	public function getContent(): string
	{
		return $this->content;
	}

	public function getCreated(): DateTime
	{
		return $this->created;
	}

	public function getUpdated(): DateTime
	{
		return $this->updated;
	}

	public function getContentChanged(): DateTime
	{
		return $this->contentChanged;
	}

	public function getDeletedAt(): DateTime
	{
		return $this->deletedAt;
	}

	public function setCategory(ArticleCategory $category): void
	{
		$this->category = $category;
	}

	public function setTitle(string $title): void
	{
		$this->title = $title;
	}

	public function setContent(string $content): void
	{
		$this->content = $content;
	}

	public function setTranslatableLocale(string $locale): void
	{
		$this->locale = $locale;
	}

	public function setDeletedAt(DateTime $deletedAt): void
	{
		$this->deletedAt = $deletedAt;
	}
}
