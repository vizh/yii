<?php

namespace partner\controllers\paperless\device;

use partner\components\Action;
use partner\models\search\PaperlessDevice;

class IndexAction extends Action
{
    public function run()
    {
        $this->getController()->render('device/index', [
            'search' => new PaperlessDevice($this->getEvent())
        ]);
    }
}