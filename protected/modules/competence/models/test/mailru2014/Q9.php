<?php
namespace competence\models\test\mailru2014;

use competence\models\Question;

class Q9 extends \competence\models\form\Multiple
{
    public function getPrev()
    {
        $baseQuestion = Question::model()->byTestId($this->getQuestion()->TestId)->byCode('Q7')->find();
        $baseQuestion->setTest($this->getQuestion()->Test);
        $result = $baseQuestion->getResult();
        if ($result['value'] == 1 || $result['value'] == 2) {
            return Question::model()->byTestId($this->getQuestion()->TestId)->byCode('Q8_1')->find();
        } else {
            return Question::model()->byTestId($this->getQuestion()->TestId)->byCode('Q8_2')->find();
        }
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            ['value', 'validateValue']
        ]);
    }

    public function validateValue($attribute, $params)
    {
        if (count($this->value) > 5) {
            $this->addError($attribute, 'Можно выбрать не более 5 вариантов.');
        }
    }
}
