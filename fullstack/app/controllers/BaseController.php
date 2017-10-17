<?php

namespace App\Controllers;

use Apitte\Core\Annotation\Controller\GroupId;
use Apitte\Core\Annotation\Controller\GroupPath;
use Apitte\Core\UI\Controller\AbstractController;

/**
 * @GroupPath("/api")
 * @GroupId("api")
 */
abstract class BaseController extends AbstractController
{

}
