<?php
namespace competence\models\test\runet2016;

use competence\models\form\Base;
use competence\models\Result;

class D2 extends Base
{
    use RouteMarket;
    
    public $subMarkets = [];

    public function rules()
    {
        return [
            ['value', 'validateValue']
        ];
    }

    public function validateValue($attribute, $params)
    {
        if (is_array($this->$attribute)) {
            foreach ($this->$attribute as $raw) {
                $val = trim($raw);
                if (strlen($val) == 0) {
                    $this->addError($attribute, 'Необходимо оценить все факторы.');
                    return;
                } elseif (!is_numeric($val)) {
                    $this->addError($attribute, 'Вводимое значение должно быть числом, дробная часть отделяется точкой.');
                    return;
                } elseif ($val < 0) {
                    $this->addError($attribute, 'Вводимое значение не может быть меньше нуля.');
                    return;
                } elseif ($val > 100) {
                    $this->addError($attribute, 'Вводимое значение не может быть больше 100.');
                    return;
                }
            }            
        } else {
            $this->addError($attribute, 'Некорректный формат ответа.');
        }
    }

    protected function getDefinedViewPath()
    {
        return 'competence.views.test.runet2016.d1';
    }

    /**
     * @throws \application\components\Exception
     * @return \competence\models\Question
     */
    public function getNext()
    {
        return $this->getNextMarketQuestion($this->getQuestion()->Test);
    }

    public function getInternalExportValueTitles()
    {
        return array_values($this->subMarkets);
    }

    public function getInternalExportData(Result $result)
    {
        $questionData = $result->getQuestionResult($this->question);
        $data = [];
        foreach ($this->subMarkets as $key => $market) {
            $data[] = isset($questionData['value'][$key]) ? $questionData['value'][$key] : '';
        }
        return $data;
    }
}