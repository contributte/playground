<?php

namespace App\Presenters;

use Nette\Application\Responses\TextResponse;
use Nette\Application\UI\Presenter;

class HomePresenter extends Presenter
{

    public function actionDefault()
    {
        $this->sendResponse(new TextResponse('This is homepage!'));
    }

}