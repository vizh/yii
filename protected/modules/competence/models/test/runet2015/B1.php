<?php
namespace competence\models\test\runet2015;

use competence\models\Question;
use \competence\models\form\Single;

class B1 extends Single
{
    private $codes = [1 => 'B2_1', 2 => 'B2_2', 3 => 'B2_3', 4 => 'B2_4'];

    public function getNext()
    {
        $value = intval($this->value);
        $code = isset($this->codes[$value]) ? $this->codes[$value] : null;
        $question = null;
        if ($code !== null) {
            $question = Question::model()->byTestId($this->question->TestId)->byCode($code)->find();
        } else {
            $question = parent::getNext();
        }
        return $question;
    }
}
