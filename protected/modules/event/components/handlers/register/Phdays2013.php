<?php
namespace event\components\handlers\register;

class Phdays2013 extends Base
{
    public function getFrom()
    {
        return 'users@runet-id.com';
    }

    public function getSubject()
    {
        if (\Yii::app()->getLanguage() == 'en') {
            return 'Successful registration на Positive Hack Days 2013';
        }
        return 'Успешная регистрация на Positive Hack Days 2013';
    }

    public function getBody()
    {
        $participant = \event\models\Participant::model()->byUserId($this->user->Id)->byEventId($this->event->Id)->findAll();
        if (sizeof($participant) !== 1) {
            return null;
        }

        if (\Yii::app()->getLanguage() == 'en') {
            $view = 'event.views.mail.register.phdays13.en';
        } else {
            $view = 'event.views.mail.register.phdays13.ru';
        }
        return \Yii::app()->getController()->renderPartial($view, ['user' => $this->user], true);
    }
}
