<?php declare(strict_types=1);

namespace App\Model\Database\Advanced\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @Gedmo\Tree(type="nested")
 * @ORM\Table
 * @ORM\Entity(repositoryClass="App\Model\Database\Advanced\Repository\ArticleCategoryRepository")
 */
class ArticleCategory
{
	/**
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 */
	private int $id;

	/**
	 * @ORM\Column(name="title", type="string", length=64)
	 */
	private string $title;

	/**
	 * @Gedmo\TreeLeft
	 * @ORM\Column(name="lft", type="integer")
	 */
	private int $lft;

	/**
	 * @Gedmo\TreeLevel
	 * @ORM\Column(name="lvl", type="integer")
	 */
	private int $lvl;

	/**
	 * @Gedmo\TreeRight
	 * @ORM\Column(name="rgt", type="integer")
	 */
	private int $rgt;

	/**
	 * @Gedmo\TreeRoot
	 * @ORM\ManyToOne(targetEntity="ArticleCategory")
	 * @ORM\JoinColumn(name="tree_root", referencedColumnName="id", onDelete="CASCADE")
	 */
	private ?self $root = NULL;

	/**
	 * @Gedmo\TreeParent
	 * @ORM\ManyToOne(targetEntity="ArticleCategory", inversedBy="children")
	 * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="CASCADE")
	 */
	private ?self $parent = NULL;

	/**
	 * @ORM\OneToMany(targetEntity="ArticleCategory", mappedBy="parent")
	 * @ORM\OrderBy({"lft" = "ASC"})
	 */
	private Collection $children;

	/**
	 * @ORM\OneToMany(targetEntity="Article", mappedBy="category")
	 */
	private Collection $articles;

	public function __construct()
	{
		$this->articles = new ArrayCollection();
	}

	public function getId(): int
	{
		return $this->id;
	}

	public function getTitle(): string
	{
		return $this->title;
	}

	public function getLvl(): int
	{
		return $this->lvl;
	}

	public function getRoot(): self
	{
		return $this->root;
	}

	public function getParent(): self
	{
		return $this->parent;
	}

	public function getArticles(): ArrayCollection
	{
		return $this->articles;
	}

	public function setTitle(string $title): void
	{
		$this->title = $title;
	}

	public function setParent(?ArticleCategory $parent = NULL): void
	{
		$this->parent = $parent;
	}

	public function setArticles(Collection $articles): void
	{
		$this->articles = $articles;
	}
}
