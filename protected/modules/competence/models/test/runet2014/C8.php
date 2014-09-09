<?php
namespace competence\models\test\runet2014;

use competence\models\Question;

class C8 extends \competence\models\form\Base
{
    use RouteMarket;

    protected $baseCode = null;

    protected $nextCodeToCompany = null;

    protected $nextCodeToComment = null;

    public $subMarkets = [];

    protected function getDefinedViewPath()
    {
        return 'competence.views.test.runet2014.c8';
    }

    public function getNext()
    {
        $baseQuestion = Question::model()->byTestId($this->getQuestion()->TestId)->byCode($this->baseCode)->find();
        $baseQuestion->setTest($this->getQuestion()->Test);
        $result = $baseQuestion->getResult();
        if ($result['value'] == '1') {
            return Question::model()->byTestId($this->getQuestion()->TestId)->byCode($this->nextCodeToCompany)->find();
        } else {
            return Question::model()->byTestId($this->getQuestion()->TestId)->byCode($this->nextCodeToComment)->find();
        }
    }


} 