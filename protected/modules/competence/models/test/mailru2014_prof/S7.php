<?php
namespace competence\models\test\mailru2014_prof;

use competence\models\Question;

class S7 extends \competence\models\form\Single {

    protected function getBaseQuestionCode()
    {
        return 'S1';
    }

    public function getNext()
    {
        $result = $this->getBaseQuestion()->getResult();
        if ($result['value'] == 1)
        {
            $model = Question::model()->byTestId($this->question->TestId)->byCode('S3_1')->find();
        }
        else
        {
            $model = Question::model()->byTestId($this->question->TestId)->byCode('S3')->find();
        }
        return $model;
    }

}
