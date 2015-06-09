<?php
namespace partner\controllers\orderitem;

use partner\components\Action;
use partner\models\search\OrderItems;

class IndexAction extends Action
{
    public function run()
    {
        $search = new OrderItems($this->getEvent());
        $this->getController()->render('index', [
            'search' => $search
        ]);
    }
}