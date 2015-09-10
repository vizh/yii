<?php
namespace competence\models\test\runet2015;

use competence\models\Question;

class C5 extends \competence\models\form\Base
{
    public function rules()
    {
        return [
            ['value', 'validateValue']
        ];
    }

    /**
     * @param $attribute
     * @param $params
     * @return bool
     */
    public function validateValue($attribute, $params)
    {
        $value = $this->value;
        for ($i = 1; $i <= 4; $i++) {
            if (empty($value[$i])) {
                $this->addError($attribute, 'Необходимо ввести названия всех четырех компаний');
                return false;
            } elseif (!is_numeric($value[$i])) {
                $this->addError($attribute, 'Вводимое значение должно быть числом, дробная часть отделяется точкой.');
                return false;
            }


        }
        return true;
    }

    /**
     * @return string|null
     */
    protected function getDefinedViewPath()
    {
        return 'competence.views.test.runet2015.c5';
    }

    public function getCompanyNames()
    {
        $code = str_replace('C5_', 'C4_', $this->getQuestion()->Code);
        $question = Question::model()->byTestId($this->getQuestion()->TestId)->byCode($code)->find();
        $question->setTest($this->getQuestion()->Test);
        $result = $question->getResult();
        return $result['value'];
    }
} 