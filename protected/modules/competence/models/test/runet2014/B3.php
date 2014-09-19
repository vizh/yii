<?php
namespace competence\models\test\runet2014;

use competence\models\Question;

class B3 extends \competence\models\form\Single
{
    use MarketIndex;

    protected $prevCodes = [];

    protected $baseCode = null;

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

    public function getNext()
    {
        if ($this->value == 2) {
            $code = 'C1_'.$this->getMarketIndex();
            return Question::model()->byTestId($this->getQuestion()->TestId)->byCode($code)->find();
        }
        return parent::getNext();
    }

    public function beforeProcess()
    {
        parent::beforeProcess();

        if ($this->value == 2) {
            $this->getQuestion()->getTest()->getResult()->setQuestionResult(parent::getNext(), []);
        }
    }

}