<?php
namespace event\components\handlers\register;

class Cloudaward2013 extends Base
{
    public function isHtml()
    {
        return true;
    }

    public function getSubject()
    {
        return 'Облака 2013 – Пригласительный билет!';
    }

    public function getBody()
    {
        $participant = \event\models\Participant::model()->byUserId($this->user->Id)->byEventId($this->event->Id)->find();
        if ($participant !== null) {
            return \Yii::app()->getController()->renderPartial('event.views.mail.register.cloudaward13', ['user' => $this->user, 'participant' => $participant], true);
        }
        return null;
    }
}
