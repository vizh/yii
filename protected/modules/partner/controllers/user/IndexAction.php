<?php
namespace partner\controllers\user;


use application\modules\partner\models\search\Participant;

class IndexAction extends \partner\components\Action
{
    public function run()
    {
        $search = new Participant($this->getEvent());

        $this->getController()->render('index', [
            'search' => $search,
            'event' => $this->getEvent()
        ]);
    }
}