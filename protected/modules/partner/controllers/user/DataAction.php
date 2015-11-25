<?php
namespace partner\controllers\user;

use application\modules\partner\models\search\ParticipantData;
use partner\components\Action;

class DataAction extends Action
{
    public function run()
    {
        $search = new ParticipantData($this->getEvent());
        $this->getController()->render('data', ['search' => $search]);
    }
}