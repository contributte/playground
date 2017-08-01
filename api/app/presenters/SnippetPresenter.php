<?php

namespace App\Presenters;

use Nette\Application\UI\Presenter;

class SnippetPresenter extends Presenter
{

    public function actionDefault()
    {
        if ($this->isAjax()) {
            $this->redrawControl('box');
        }
    }

}