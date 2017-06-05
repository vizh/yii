<?php
namespace event\components\handlers\invite\disapprove;

class Itkadry13 extends Base
{
    public function getSubject()
    {
        return 'Аккредитация на пресс-конференцию «Кадры в ИТ и инновациях. Профессии будущего»';
    }

    public function getBody()
    {
        return \Yii::app()->getController()->renderPartial('event.views.mail.invite.disapprove.itkadry13', ['user' => $this->user], true);
    }
}