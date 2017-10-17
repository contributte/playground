<?php

namespace App\Controllers;

use Apitte\Core\Annotation\Controller\GroupId;
use Apitte\Core\Annotation\Controller\GroupPath;

/**
 * @GroupPath("/v1")
 * @GroupId("v1")
 */
abstract class BaseV1Controller extends BaseController
{

}
