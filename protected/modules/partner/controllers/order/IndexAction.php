<?php
namespace partner\controllers\order;

use application\modules\partner\models\search\Orders;

class IndexAction extends \partner\components\Action
{
    public function run()
    {
        $search = new Orders($this->getEvent());
        $this->getController()->render('index', [
            'search' => $search
        ]);
    }
}