<?php
namespace competence\models\test\runet2014;

class A1 extends \competence\models\form\Input
{
    public function __construct($question, $scenario = '')
    {
        parent::__construct($question, $scenario);
        if (empty($this->value)) {
            $this->value = \Yii::app()->getUser()->getCurrentUser()->getFullName();
        }
    }
}
