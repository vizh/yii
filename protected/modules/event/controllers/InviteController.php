<?php

class InviteController extends application\components\controllers\PublicMainController
{
    public function actionIndex($idName, $code)
    {
        $event = \event\models\Event::model()->byIdName($idName)->find();
        if ($event == null) {
            throw new \CHttpException(404);
        }

        $invite = \event\models\InviteCode::model()->byCode($code)->find();
        if ($invite == null || $invite->EventId !== $event->Id) {
            throw new \CHttpException(404);
        }

        $this->setPageTitle(\Yii::t('app', 'Активация прилашения'));
        $this->render('index', ['event' => $event, 'invite' => $invite]);

        if ($invite->UserId == null
            && !\Yii::app()->getUser()->getIsGuest()
        ) {
            $invite->UserId = \Yii::app()->getUser()->getId();
            $invite->ActivationTime = date('Y-m-d H:i:s');
            $invite->save();

            if (empty($event->Parts)) {
                $event->registerUser(\Yii::app()->getUser()->getCurrentUser(), $invite->Role);
            } else {
                $event->registerUserOnAllParts(\Yii::app()->getUser()->getCurrentUser(), $invite->Role);
            }
        }
    }
}
