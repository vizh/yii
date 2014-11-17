<?php
namespace competence\models\test\riw14;

use event\models\Participant;

class D2 extends \competence\models\form\Single
{
    public function getNext()
    {
        $participant = Participant::model()->byUserId(\Yii::app()->getUser()->getId())->byEventId(889)->find();
        if ($participant == null || $participant->RoleId == 1) {
            return null;
        }
        return parent::getNext();
    }
}
