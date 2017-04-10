<?php
namespace partner\controllers\paperlessdevice;

use partner\components\Action;
use partner\models\search\PaperlessDevice;

class IndexAction extends Action
{
    public function run()
    {
        $search = new PaperlessDevice($this->getEvent());
        $this->getController()->render('index', [
            'search' => $search
        ]);
    }
}