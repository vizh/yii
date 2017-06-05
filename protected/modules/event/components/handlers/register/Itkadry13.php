<?php
namespace event\components\handlers\register;

class Itkadry13 extends Base
{
    public function getSubject()
    {
        return 'Вы аккредитованны на пресс-конференцию «Кадры в ИТ и инновациях. Профессии будущего»';
    }

    public function getBody()
    {
        return \Yii::app()->getController()->renderPartial('event.views.mail.register.itkadry13', ['user' => $this->user], true);
    }
}