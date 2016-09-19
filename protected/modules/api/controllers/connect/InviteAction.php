<?php
namespace api\controllers\connect;

use connect\models\forms\Meeting;

class InviteAction extends \api\components\Action
{
    public function run()
    {
        $form = new Meeting();
        $form->fillFromPost();
        $form->createActiveRecord();

        $this->setResult(['MeetingId' => $form->model->Id, 'Success' => $form->model->Id ? true : false]);
    }
}