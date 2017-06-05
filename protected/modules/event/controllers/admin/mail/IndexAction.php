<?php
namespace event\controllers\admin\mail;

class IndexAction extends \CAction
{
    public function run($eventId)
    {
        $event = \event\models\Event::model()->findByPk($eventId);
        if ($event == null) {
            throw new \CHttpException(404);
        }

        $mails = isset($event->MailRegister) ? unserialize(base64_decode($event->MailRegister)) : [];
        $this->getController()->setPageTitle(\Yii::t('app', 'Список регистрационных писем'));
        $this->getController()->render('index', ['mails' => $mails, 'event' => $event]);
    }
} 