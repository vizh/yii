<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 08.09.14
 * Time: 17:44
 */

namespace competence\models\test\runet2014;

use competence\models\Question;

class D4 extends D
{
    public function getPrev()
    {
        if (!$this->getIsMarketParticipant($this->getQuestion()->Test)) {
            $question = Question::model()->byCode('D2')->byTestId($this->getQuestion()->TestId)->find();
            $question->Test = $this->getQuestion()->getTest();
            return $question;
        }
        return parent::getPrev();
    }

    public function getTitle()
    {
        $title = parent::getTitle();
        return sprintf($title, $this->getSegment());
    }
} 