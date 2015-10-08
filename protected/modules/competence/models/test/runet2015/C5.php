<?php
namespace competence\models\test\runet2015;

use competence\models\Question;
use competence\models\Result;

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
        foreach ($this->getCompanyNames() as $i => $name) {
            if (empty($value[$i])) {
                $this->addError($attribute, 'Необходимо ввести значения для всех указанных компаний.');
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

        $names = [];
        $i = 1;

        foreach ($question->getResult()['value'] as $value) {
            if (!empty($value)) {
                $names[$i] = $value;
                $i++;
            }
        }
        return $names;
    }

    /**
     * @return array
     */
    protected function getInternalExportValueTitles()
    {
        $data = [];
        for ($i = 1; $i <= 4; $i++) {
            $data[$i] = 'Компания ' . $i;
        }
        return $data;
    }

    /**
     * @param Result $result
     * @return array
     */
    protected function getInternalExportData(Result $result)
    {
        $questionData = $result->getQuestionResult($this->question);
        $data = [];
        for ($i = 1; $i <= 4; $i++) {
            $data[$i] = isset($questionData['value'][$i]) ? $questionData['value'][$i] : '';
        }
        return $data;
    }
} 