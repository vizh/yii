<?php
namespace event\components\handlers\invite\disapprove;

class Visualdata15 extends Base
{
    public function getSubject()
    {
        return 'Семинар «Visual Data»';
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return \Yii::app()->getController()->renderPartial('event.views.mail.invite.disapprove.visualdata15', ['user' => $this->user], true);
    }
}
