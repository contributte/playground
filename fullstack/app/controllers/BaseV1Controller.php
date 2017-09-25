<?php

namespace App\Controllers;

use Apitte\Core\Annotation\Controller\Group;
use Apitte\Core\Annotation\Controller\GroupPath;

/**
 * @GroupPath("/v1")
 * @Group("apiv1")
 */
abstract class BaseV1Controller extends BaseController
{

}
