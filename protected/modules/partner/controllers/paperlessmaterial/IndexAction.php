<?php
namespace partner\controllers\paperlessmaterial;

use partner\components\Action;
use partner\models\search\PaperlessMaterial;

class IndexAction extends Action
{
    public function run()
    {
        $search = new PaperlessMaterial($this->getEvent());
        $this->getController()->render('index', [
            'search' => $search
        ]);
    }
}