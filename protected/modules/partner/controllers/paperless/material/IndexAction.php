<?php
namespace partner\controllers\paperless\material;

use partner\components\Action;
use partner\models\search\PaperlessMaterial;

class IndexAction extends Action
{
    public function run()
    {
        $this->getController()->render('material/index', [
            'search' => new PaperlessMaterial($this->getEvent())
        ]);
    }
}