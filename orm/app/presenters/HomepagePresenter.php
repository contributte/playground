<?php

namespace App\Presenters;

use App\Model\Database\Entity\Post;
use Nette\Application\UI\Presenter;
use Nettrine\ORM\EntityManager;

class HomepagePresenter extends Presenter
{

	/** @var EntityManager @inject */
	public $em;

	/**
	 * @return void
	 */
	public function renderDefault()
	{
		$postRepository = $this->em->getRepository(Post::class);
		$this->template->posts = $postRepository->findAll();
	}

}
