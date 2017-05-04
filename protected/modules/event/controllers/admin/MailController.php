<?php

use event\models\Event;
use event\models\Participant;
use mail\components\mailers\SESMailer;

class MailController extends \application\components\controllers\AdminMainController
{
    public function actions()
    {
        return [
            'index' => '\event\controllers\admin\mail\IndexAction',
            'edit' => '\event\controllers\admin\mail\EditAction'
        ];
    }

    /**
     * @param int $idEvent
     * @param string $idMail
     * @throws CHttpException
     */
    public function actionView($idEvent, $idMail)
    {
        $event = Event::model()
            ->findByPk($idEvent);

        if ($event === null) {
            throw new CHttpException(404);
        }

        // Определим текущего пользователя и его роль на мероприятии
        $currentUser = Yii::app()->getUser()->getCurrentUser();
        $participant = Participant::model()
            ->byEventId($event->Id)
            ->byUserId($currentUser->Id)
            ->find();

        if ($participant === null) {
            echo "Вы не зарегистрированы на мероприятие {$event->Title}";
            exit;
        }

        $sendr = ucfirst($event->IdName);
        $class = Yii::getExistClass('\event\components\handlers\register', $sendr, 'Base');

        /** @var \event\components\handlers\register\Base $mail */
        $mail = new $class(new SESMailer(), new CModelEvent($event, [
            'user' => $currentUser,
            'role' => $participant->Role
        ]));

        echo $mail->getBody();
    }
}