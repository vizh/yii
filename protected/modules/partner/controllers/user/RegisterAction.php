<?php
namespace partner\controllers\user;

use partner\models\forms\user\Register;

class RegisterAction extends \partner\components\Action
{
    public function run()
    {
        $request = \Yii::app()->getRequest();
        $form = new Register($this->getEvent());
        if ($request->getIsPostRequest()) {
            $form->fillFromPost();
            $user = $form->createActiveRecord();
            if ($user !== null) {
                $this->getController()->redirect(['edit', 'id' => $user->RunetId]);
            }
        }
        $this->getController()->render('register', ['form' => $form]);
    }

    public function getRandomEmail()
    {
        return 'nomail'.$this->getEvent()->Id.'+'.substr(md5(microtime()), 0, 8).'@runet-id.com';
    }
}