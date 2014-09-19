<?php
namespace competence\models\test\runet2014;

use competence\models\form\Textarea;
use competence\models\Question;

class C10A extends C3A
{
    use RouteMarket, MarketIndex;

    public function getCodes()
    {
        $result = $this->getBaseQuestion()->getResult();
        if (!empty($result) && $result['value'] == 1) {
            return ['C7', 'C8', 'C9', 'C10'];
        } else {
            return ['C7', 'C8'];
        }
    }

    protected function getBaseQuestionCode()
    {
        return 'B4_'.$this->getMarketIndex();
    }

    public function getPrev()
    {
        $result = $this->getBaseQuestion()->getResult();
        $code = null;
        if (!empty($result) && $result['value'] == 1) {
            $code = 'C10_';
        } else {
            $code = in_array($this->getMarketIndex(), [1, 2, 3, 5, 7, 8, 10, 11, 12]) ? 'C8_' : 'C7_';
        }
        return Question::model()->byTestId($this->getQuestion()->TestId)->byCode($code.$this->getMarketIndex())->find();
    }

    public function getNext()
    {
        return $this->getNextMarketQuestion($this->getQuestion()->Test);
    }
} 