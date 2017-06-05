<?php

use event\models\Event;
use user\models\UnsubscribeEventMail;

class UnsubscribeController extends \application\components\controllers\PublicMainController
{
    public function actionIndex($email, $hash, $eventIdName = null)
    {
        $users = \user\models\User::model()->byEmail($email)->findAll();
        if (empty($users)) {
            throw new CHttpException(500, 'Не найден пользователь с email: '.$email);
        }

        $event = null;
        if ($eventIdName !== null) {
            $event = Event::model()->byIdName($eventIdName)->find();
            if ($event == null) {
                throw new \CHttpException(500, 'Не корректное мероприятие в отписки пользователя. Пришедший idName мероприятия: '.$eventIdName.' Email пользователя: '.$email);
            }
        }

        /** @var \user\models\User $user */
        foreach ($users as $user) {
            if ($user->getHash() == $hash) {
                $this->setPageTitle(\Yii::t('app', 'Подписка успешно отменена'));
                if ($event !== null) {
                    $unsubscribeExists = UnsubscribeEventMail::model()->byEventId($event->Id)->byUserId($user->Id)->exists();
                    if (!$unsubscribeExists) {
                        $unsubscribe = new UnsubscribeEventMail();
                        $unsubscribe->EventId = $event->Id;
                        $unsubscribe->UserId = $user->Id;
                        $unsubscribe->save();
                    }
                    $this->render('event', ['event' => $event]);
                } else {
                    $user->Settings->UnsubscribeAll = true;
                    $user->Settings->save();
                    $this->render('index');
                }
                return;
            }
        }

        throw new \CHttpException(500, 'Не корректный код отписки пользователя. Пришедший код: '.$hash.' Email пользователя: '.$email);
    }
}
