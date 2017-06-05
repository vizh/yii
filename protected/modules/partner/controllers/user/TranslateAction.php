<?php
namespace partner\controllers\user;

use application\helpers\Flash;
use partner\models\forms\user\Translate;
use user\models\User;

class TranslateAction extends \partner\components\Action
{
    public function run($id)
    {
        $user = User::model()->byRunetId($id)->byEventId($this->getEvent()->Id)->find();
        if ($user == null) {
            throw new \CHttpException(404);
        }

        $locales = \Yii::app()->params['Languages'];

        /** @var Translate[] $forms */
        $forms = [];
        foreach ($locales as $locale) {
            $forms[] = new Translate($locale, $user);
        }

        /** @var \CHttpRequest $request */
        $request = \Yii::app()->getRequest();
        if ($request->getIsPostRequest()) {
            $valid = true;

            foreach ($forms as $locale => $form) {
                $form->fillFromPost();
                if (!$form->validate()) {
                    $valid = false;
                }
            }

            if ($valid) {
                foreach ($forms as $locale => $form) {
                    $form->updateActiveRecord();
                }
                Flash::setSuccess(\Yii::t('app', 'Персональные данные пользователя сохранены!'));
                $this->getController()->refresh();
            }
        }
        $this->getController()->render('translate', ['forms' => $forms, 'locales' => $locales, 'user' => $user]);
    }
}
