<?php
namespace partner\controllers\paperlessevent;

use partner\components\Action;
use partner\models\search\PaperlessEvent;

class IndexAction extends Action
{
    public function run()
    {
        $search = new PaperlessEvent($this->getEvent());
        $this->getController()->render('index', [
            'search' => $search
        ]);
    }
}