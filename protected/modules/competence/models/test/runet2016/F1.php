<?php
namespace competence\models\test\runet2016;

use competence\models\form\Base;
use competence\models\Question;

class F1 extends Base
{
    protected function getBaseQuestionCode()
    {
        return 'A1';
    }

    public function getPrev()
    {
        $result = $this->getBaseQuestion()->getResult();
        $code = 'E3_'.$result['value'];
        return Question::model()->byTestId($this->getQuestion()->TestId)->byCode($code)->find();
    }
}
