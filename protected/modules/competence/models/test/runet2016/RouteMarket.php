<?php
namespace competence\models\test\runet2016;

use competence\models\Question;
use competence\models\Test;

trait RouteMarket
{
    protected $baseCodeMarket = null;    

    protected $lastCode = null;

    protected $nextCodes = [];

    /**
     * @param Test $test
     * @return Question
     */
    public function getNextMarketQuestion($test)
    {
        $baseQuestion = Question::model()->byTestId($test->Id)->byCode($this->baseCodeMarket)->find();
        $baseQuestion->setTest($test);
        $result = $baseQuestion->getResult();
        foreach ($this->nextCodes as $value => $code) {
            if (in_array($value, $result['value'])) {
                return Question::model()->byTestId($test->Id)->byCode($code)->find();
            }
        }

        return Question::model()->byTestId($test->Id)->byCode($this->lastCode)->find();
    }
} 