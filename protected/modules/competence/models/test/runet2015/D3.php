<?php
namespace competence\models\test\runet2015;

use competence\models\form\Single;
use competence\models\Question;

class D3 extends Single
{
    /**
     * @throws \application\components\Exception
     * @return \competence\models\Question
     */
    public function getNext()
    {
        if ($this->value == 8) {
            $test = $this->getQuestion()->Test;
            $d6 = Question::model()->byTestId($test->Id)->byCode('D6')->find();
            $d6->setTest($test);
            return $d6;
        }
        return parent::getNext();
    }

}
