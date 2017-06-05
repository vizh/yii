<?php
namespace user\controllers\setting;

use user\models\forms\setting\Subsciption;
use user\models\UnsubscribeEventMail;

class SubscriptionAction extends \CAction
{
    public function run()
    {
        $request = \Yii::app()->getRequest();
        $user = \Yii::app()->user->getCurrentUser();
        $form = new Subsciption();
        $form->attributes = $request->getParam(get_class($form));
        if ($request->getIsPostRequest()) {
            $user->Settings->UnsubscribeAll = ($form->Subscribe == 1) ? false : true;
            $user->Settings->save();
            foreach ($form->UnsubscribeEvents as $eventId => $value) {
                if ($value == 0) {
                    $unsubscribe = UnsubscribeEventMail::model()->byUserId($user->Id)->byEventId($eventId)->find();
                    if ($unsubscribe !== null) {
                        $unsubscribe->delete();
                    }
                }
            }

            \Yii::app()->user->setFlash('success', \Yii::t('app', 'Настройки подписки успешно сохранены!'));
            $this->getController()->refresh();
        } else {
            if ($user->Settings->UnsubscribeAll) {
                $form->Subscribe = 0;
            }
        }

        $this->getController()->bodyId = 'user-account';
        $this->getController()->setPageTitle(\Yii::t('app', 'Редактирование профиля'));
        $this->getController()->render('subscription', ['form' => $form]);
    }
}
