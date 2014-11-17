<?php
namespace competence\models\test\riw14;

use event\models\Participant;

class A2 extends \competence\models\form\Multiple
{
    private $options = null;

    public function getOptions()
    {
        if ($this->options == null) {
            $this->options = $this->Values;
            $participant = Participant::model()->byUserId(\Yii::app()->getUser()->getId())->byEventId(889)->find();
            if ($participant == null || $participant->RoleId == 1) {
                foreach ($this->options as $key => $option) {
                    if (in_array($option->key, [2, 3, 4])) {
                        unset($this->options[$key]);
                    }
                }
            }
        }
        return $this->options;
    }

    protected function getDefinedViewPath()
    {
        return null;
    }


}
