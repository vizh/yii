<?php
namespace competence\models\test\mailru2014;

use competence\models\Question;

class Q9 extends \competence\models\form\Multiple
{
    public function getPrev()
    {
        $q7 = Question::model()->byTestId($this->getQuestion()->TestId)->byCode('Q7')->find();
        $q7->setTest($this->getQuestion()->Test);
        $result = $q7->getResult();
        if ($result['value'] == 1 || $result['value'] == 2) {
            $q2_1 = Question::model()->byTestId($this->getQuestion()->TestId)->byCode('Q2_1')->find();
            $q2_1->setTest($this->getQuestion()->Test);
            $resultQ2_1 = $q2_1->getResult();

            if (isset($resultQ2_1['value']) && $resultQ2_1['value'] == 1) {
                return Question::model()->byTestId($this->getQuestion()->TestId)->byCode('Q8_1')->find();
            } else {
                return Question::model()->byTestId($this->getQuestion()->TestId)->byCode('Q7')->find();
            }
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
