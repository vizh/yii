<?php
namespace partner\controllers\paperless\event;

use partner\components\Action;
use partner\models\search\PaperlessEvent;

class IndexAction extends Action
{
    public function run()
    {
        $this->getController()->render('event/index', [
            'search' => new PaperlessEvent($this->getEvent())
        ]);
    }
}