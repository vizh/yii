<?php
namespace competence\models\test\runet2015;

use competence\models\form\Base;
use competence\models\Result;

class C9 extends Base
{
    use RouteMarket;

    public $subMarkets = [];

    protected function getDefinedViewPath()
    {
        return 'competence.views.test.runet2015.c9';
    }

    public function rules()
    {
        return [
            ['value', 'validateValue']
        ];
    }

    public function validateValue($attribute, $params)
    {
        $valid = false;
        if (is_array($this->$attribute)) {
            $sum = 0;
            foreach ($this->$attribute as $val) {
                $sum += $val;
            }

            if ($sum == 100)
                $valid = true;
        }

        if (!$valid)
            $this->addError($attribute, 'Сумма оборота всех компаний должна быть равной 100%');
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

    /**
     * @throws \application\components\Exception
     * @return \competence\models\Question
     */
    public function getNext()
    {
        return $this->getNextMarketQuestion($this->getQuestion()->Test);
    }


} 