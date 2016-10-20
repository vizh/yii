<?php
namespace partner\controllers\connect;

use application\modules\partner\models\search\Meeting;

class IndexAction extends \partner\components\Action
{
    public function run($export = false)
    {
        $search = new Meeting($this->getEvent());

        $this->getController()->render($export ? 'index_excel' : 'index', [
            'search' => $search,
            'event' => $this->getEvent(),
        ]);
    }
}