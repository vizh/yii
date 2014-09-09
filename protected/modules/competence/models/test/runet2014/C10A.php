<?php
namespace competence\models\test\runet2014;

use competence\models\form\Textarea;
use competence\models\Question;

class C10A extends Textarea
{
    use RouteMarket, MarketIndex;

    public function getPrev()
    {
        $marketIndex = $this->getMarketIndex();
        $baseQuestion = Question::model()->byTestId($this->getQuestion()->TestId)->byCode('B4_'.$marketIndex)->find();
        $baseQuestion->Test = $this->getQuestion()->Test;
        $result = $baseQuestion->getResult();
        $code = null;
        if ($result['value'] == 1) {
            $code = 'B10_';
        } else {
            $code = in_array($marketIndex, [1, 2, 3, 5, 7, 8, 10, 11, 12]) ? 'C8_' : 'C7_';
        }
        return Question::model()->byTestId($this->getQuestion()->TestId)->byCode($code.$marketIndex)->find();
    }

    public function getNext()
    {
        return $this->getNextMarketQuestion($this->getQuestion()->Test);
    }
} 