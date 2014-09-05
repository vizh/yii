<?php
namespace event\components\handlers\invite\disapprove;

class Svmr14_123 extends Base
{
    public function getSubject()
    {
        return 'Конференция «Silicon Valley Meets Russia»';
    }

    public function getBody()
    {
        return \Yii::app()->getController()->renderPartial('event.views.mail.invite.disapprove.svmr14', ['user' => $this->user], true);
    }
} 