<?php
namespace competence\models\test\runet2016;

use competence\models\form\Input;
use competence\models\Question;

class E1 extends Input
{
    protected $prevCodes = [];

    public function getPrev()
    {
        $result = $this->getBaseQuestion()->getResult();

        foreach ($this->prevCodes as $value => $code) {
            if (in_array($value, $result['value'])) {
                return Question::model()->byTestId($this->getQuestion()->TestId)->byCode($code)->find();
            }
        }
        return Question::model()->byTestId($this->getQuestion()->TestId)->byCode('B2')->find();
    }
}