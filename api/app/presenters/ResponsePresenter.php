<?php

namespace App\Presenters;

use Nette\Application\Responses\FileResponse;
use Nette\Application\Responses\JsonResponse;
use Nette\Application\Responses\TextResponse;
use Nette\Application\UI\Presenter;

class ResponsePresenter extends Presenter
{

    public function actionDefault()
    {
        $this->sendResponse(new TextResponse('TESTx!'));
    }

    public function actionJson()
    {
        $this->sendResponse(new JsonResponse(['data' => 'TEST!']));
    }

    public function actionFile()
    {
        $this->sendResponse(new FileResponse(__FILE__));
    }

    public function actionRedirect()
    {
        $this->redirect('json');
    }

}