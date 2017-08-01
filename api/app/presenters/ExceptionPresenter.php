<?php

namespace App\Presenters;

use InvalidArgumentException;
use Nette\Application\BadRequestException;
use Nette\Application\UI\Presenter;

class ExceptionPresenter extends Presenter
{

    public function actionDefault()
    {
        throw new InvalidArgumentException('Foobar');
    }

    public function action404()
    {
        throw new BadRequestException('Bad place', 404);
    }

}