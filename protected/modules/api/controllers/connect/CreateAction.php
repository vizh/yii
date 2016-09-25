<?php
namespace api\controllers\connect;

use connect\models\forms\Meeting;

class CreateAction extends \api\components\Action
{
    public function run()
    {
        $form = new Meeting();
        $form->fillFromPost();
        $success = $form->createActiveRecord();

        if ($success){
            $this->setResult([
                'Success' => true,
                'Meeting' => $this->getAccount()->getDataBuilder()->createMeeting($form->model),
                'Errors' => $form->errors
            ]);
        }
        else{
            $this->setResult([
                'Success' => false,
                'Errors' => $form->errors
            ]);
        }

    }
}