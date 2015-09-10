<?php
namespace competence\models\test\runet2015;

use competence\models\form\Textarea;
use competence\models\Question;

class D6 extends Textarea
{
    /**
     * @throws \application\components\Exception
     * @return \competence\models\Question
     */
    public function getPrev()
    {
        $test = $this->getQuestion()->Test;
        $d3 = Question::model()->byTestId($test->Id)->byCode('D3')->find();
        $d3->setTest($test);
        if ($d3->getResult()['value'] == 8) {
            return $d3;
        }
        return parent::getPrev();
    }

}
