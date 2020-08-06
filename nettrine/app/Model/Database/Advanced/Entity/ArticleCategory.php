<?php declare(strict_types=1);

namespace App\Model\Database\Advanced\Entity;

use Doctrine\Common\Collections\ArrayCollection;
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
	private $id;

	/**
	 * @ORM\Column(name="title", type="string", length=64)
	 */
	private $title;

	/**
	 * @Gedmo\TreeLeft
	 * @ORM\Column(name="lft", type="integer")
	 */
	private $lft;

	/**
	 * @Gedmo\TreeLevel
	 * @ORM\Column(name="lvl", type="integer")
	 */
	private $lvl;

	/**
	 * @Gedmo\TreeRight
	 * @ORM\Column(name="rgt", type="integer")
	 */
	private $rgt;

	/**
	 * @Gedmo\TreeRoot
	 * @ORM\ManyToOne(targetEntity="ArticleCategory")
	 * @ORM\JoinColumn(name="tree_root", referencedColumnName="id", onDelete="CASCADE")
	 */
	private $root;

	/**
	 * @Gedmo\TreeParent
	 * @ORM\ManyToOne(targetEntity="ArticleCategory", inversedBy="children")
	 * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="CASCADE")
	 */
	private $parent;

	/**
	 * @ORM\OneToMany(targetEntity="ArticleCategory", mappedBy="parent")
	 * @ORM\OrderBy({"lft" = "ASC"})
	 */
	private $children;

	/**
	 * @ORM\OneToMany(targetEntity="Article", mappedBy="category")
	 */
	private $articles;

	public function __construct()
	{
		$this->articles = new ArrayCollection();
	}

	public function getId()
	{
		return $this->id;
	}

	public function getTitle()
	{
		return $this->title;
	}

	public function getLvl()
	{
		return $this->lvl;
	}

	public function getRoot()
	{
		return $this->root;
	}

	public function getParent()
	{
		return $this->parent;
	}

	public function getArticles()
	{
		return $this->articles;
	}

	public function setTitle($title)
	{
		$this->title = $title;
	}

	public function setParent(?ArticleCategory $parent = null)
	{
		$this->parent = $parent;
	}

	public function setArticles($articles)
	{
		$this->articles = $articles;
	}
}
