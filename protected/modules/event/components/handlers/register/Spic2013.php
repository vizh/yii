<?php
namespace event\components\handlers\register;

class Spic2013 extends Base
{
    public function getSubject()
    {
        return 'Регистрация на СПИК-2013';
    }

    public function getBody()
    {
        if ($this->role->Id == 24) {
            return null;
        }
        return \Yii::app()->getController()->renderPartial('event.views.mail.register.spic13', ['user' => $this->user, 'role' => $this->role], true);
    }
}
