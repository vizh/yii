<?php
namespace oauth\controllers\main;

use user\models\forms\SetPassword;

class SetPasswordAction extends \CAction
{
    public function run($hash)
    {
        $user = \Yii::app()->getUser();
        if ($user->getIsGuest() || !$user->getCurrentUser()->checkRecoveryHash($hash)) {
            throw new \CHttpException(500);
        }

        $form = new SetPassword();

        $request = \Yii::app()->getRequest();
        $form->attributes = $request->getParam(get_class($form));
        if (!empty($form->Skip)) {
            $form->setScenario(SetPassword::SCENARIO_SKIP_VALIDATION);
        }

        if ($request->getIsPostRequest() && $form->validate()) {
            if ($form->getScenario() != SetPassword::SCENARIO_SKIP_VALIDATION) {
                $user->getCurrentUser()->changePassword($form->Password);
            }
            $this->getController()->redirect(
                $this->getController()->createUrl('/oauth/main/dialog')
            );
        }

        $this->getController()->render('setpassword', ['form' => $form]);
    }
} 