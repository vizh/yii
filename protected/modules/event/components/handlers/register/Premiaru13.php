<?php
namespace event\components\handlers\register;

class Premiaru13 extends Base
{
    public function getSubject()
    {
        if ($this->role->Id == 2) {
            return 'Премия Рунета - аккредитация';
        }
        return '';
    }

    public function getBody()
    {
        if ($this->role->Id == 2) {
            return \Yii::app()->getController()->renderPartial('event.views.mail.register.premiaru13-smi', ['user' => $this->user], true);
        }
        return null;
    }
}