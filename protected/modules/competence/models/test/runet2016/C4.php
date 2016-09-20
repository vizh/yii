<?php
namespace competence\models\test\runet2016;

use competence\models\form\Base;
use competence\models\Result;

class C4 extends Base
{
    protected function getDefinedViewPath()
    {
        return 'competence.views.test.runet2016.c4';
    }

    public function rules()
    {
        return [
            ['value', 'validateValue']
        ];
    }

    private $estimation_keys = ['pos', 'neg'];
    private $rate_keys = ['weak', 'med', 'strong', 'v_strong'];

    public function validateValue($attribute, $params)
    {
        $not_empty_rows = 0;
        if (is_array($this->$attribute)) {
            foreach ($this->$attribute as $val) {
                $factor = trim($val['factor']);
                if (!empty($factor)) {
                    $not_empty_rows++;

                    $est = $val['estimation'];
                    $rate = $val['rate'];

                    if (empty($est) || empty($rate) || !in_array($est, $this->estimation_keys)
                        || !in_array($rate, $this->rate_keys)) {
                        $this->addError($attribute, 'Для фактора "'.$factor.'" должны быть выбраны оценка и степень влияния.');
                    }
                }
            }
        }

        if ($not_empty_rows == 0) {
            $this->addError($attribute, 'Необходимо заполнить хотя бы один фактор.');
        }
    }

    public function getInternalExportValueTitles()
    {
        return [
            'Фактор 1', 'Оценка', 'Степень',
            'Фактор 2', 'Оценка', 'Степень',
            'Фактор 3', 'Оценка', 'Степень',
            'Фактор 4', 'Оценка', 'Степень',
            'Фактор 5', 'Оценка', 'Степень',
        ];
    }

    public function getInternalExportData(Result $result)
    {
        $questionData = $result->getQuestionResult($this->question);
        $data = [];
        if (!empty($questionData['value'])) {
            foreach ($questionData['value'] as $row) {
                $data[] = $row['factor'];
                $data[] = $row['estimation'];
                $data[] = $row['rate'];
            }
        } else {
            $data = [
                '', '', '',
                '', '', '',
                '', '', '',
                '', '', '',
                '', '', ''
            ];
        }
        return $data;
    }

}