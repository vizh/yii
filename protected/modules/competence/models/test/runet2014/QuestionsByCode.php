<?php
namespace competence\models\test\runet2014;

use competence\models\Question;

trait QuestionsByCode
{
    use MarketIndex;

    /**
     * @return string[]
     */
    public function getCodes()
    {
        return [];
    }

    /**
     * @param int $testId
     * @param string[] $codes
     * @return \competence\models\Question[]
     */
    public function getQuestions($testId, $codes)
    {
        $market = $this->getMarketIndex();
        foreach ($codes as $key => $code) {
            $codes[$key] = $code . '_' . $market;
        }
        $criteria = new \CDbCriteria();
        $criteria->condition = 't."Code" IN (\'' . implode('\',\'', $codes) . '\')';
        $criteria->order = 't."Sort"';
        return Question::model()->byTestId($testId)->findAll($criteria);
    }
} 