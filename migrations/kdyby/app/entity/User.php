<?php

namespace App\Entity;

use Kdyby\Doctrine\Entities\Attributes\Identifier;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class User
{

	use Identifier;

	/**
	 * @var string
	 * @ORM\Column(unique=TRUE, type="string", length=255, nullable=FALSE)
	 */
	private $email;

	/**
	 * @var string
	 * @ORM\Column(type="string", length=255, nullable=FALSE)
	 */
	private $firstName;

	/**
	 * @var string
	 * @ORM\Column(type="string", length=255, nullable=FALSE)
	 */
	private $lastName;

	/**
	 * @var string
	 * @ORM\Column(type="string", length=255, nullable=TRUE)
	 */
	private $password;


}
