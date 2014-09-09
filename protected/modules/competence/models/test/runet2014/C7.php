<?php
namespace competence\models\test\runet2014;

use competence\models\Question;

class C7 extends \competence\models\form\Base
{
    protected $baseCode = null;

    protected $nextCodeToCompany = null;

    protected $nextCodeToComment = null;

    protected function getDefinedViewPath()
    {
        return 'competence.views.test.runet2014.c7';
    }

    public function getNext()
    {
        if ($this->question->NextQuestionId !== null) {
            return $this->question->Next;
        }
        $baseQuestion = Question::model()->byTestId($this->getQuestion()->TestId)->byCode($this->baseCode)->find();
        $baseQuestion->setTest($this->getQuestion()->Test);
        $result = $baseQuestion->getResult();
        if ($result['value'] == '1') {
            return Question::model()->byTestId($this->getQuestion()->TestId)->byCode($this->nextCodeToCompany)->find();
        } else {
            return Question::model()->byTestId($this->getQuestion()->TestId)->byCode($this->nextCodeToComment)->find();
        }
    }
}