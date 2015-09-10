<?php
namespace competence\models\test\runet2015;

use competence\models\form\Single;
use competence\models\Question;

class B3 extends Single
{
    protected $prevCodes = [];
    protected $baseCode;

    public function getPrev()
    {
        $baseQuestion = Question::model()->byTestId($this->getQuestion()->TestId)->byCode($this->baseCode)->find();
        $baseQuestion->setTest($this->getQuestion()->Test);
        $result = $baseQuestion->getResult();

        foreach ($this->prevCodes as $value => $code) {
            if (in_array($value, $result['value'])) {
                return Question::model()->byTestId($this->getQuestion()->TestId)->byCode($code)->find();
            }
        }
        return $baseQuestion;
    }

}