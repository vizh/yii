<?php
namespace competence\models\test\riw14;

use event\models\Participant;

class A1 extends \competence\models\form\Multiple
{
    public function __construct($question, $scenario = '')
    {
        parent::__construct($question, $scenario);
        $exists = Participant::model()->byUserId(\Yii::app()->getUser()->getId())->byEventId(889)->exists();
        if (!$exists) {
            throw new \CHttpException(404);
        }
    }

    public function getNext()
    {
        foreach ($this->value as $val) {
            if ($val == 4 || $val == 5) {
                return null;
            }
        }
        return parent::getNext();
    }
}
