<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 08.09.14
 * Time: 16:33
 */

namespace competence\models\test\runet2014;


use competence\models\form\Base;
use competence\models\Question;

class D extends Base
{
    private $initiatives = null;
    public function getInitiatives()
    {
        if ($this->initiatives == null) {
            $test = $this->getQuestion()->getTest();
            $question = Question::model()->byCode('D2')->byTestId($test->Id)->find();
            $question->Test = $test;
            $result = $question->Test->getResult()->getQuestionResult($question);
            $values = $result['value'];

            $this->initiatives = [];
            $d2 = new D2($question);

            foreach ($values as $key => $value) {
                if ($value != 'not') {
                    $this->initiatives[$key] = $d2->getQuestions()[$key];
                }
            }
        }
        return $this->initiatives;
    }

    public function getSegment()
    {
        $test = $this->getQuestion()->getTest();
        $question = Question::model()->byCode('B1')->byTestId($test->Id)->find();
        $question->Test = $test;
        $result = $question->Test->getResult()->getQuestionResult($question);
        $values = $question->getFormData()['Values'];
        foreach ($values as $value) {
            if ($value->key == $result['value'])
                return $value->title;
        }
    }

    public function rules()
    {
        return [
            ['value', 'valueValidator'],
        ];
    }

    public function valueValidator($attribute, $params) {
        foreach ($this->value as $val) {
            if (empty($val)) {
                $this->addError($attribute, 'Необходимо выбрать одно значение для всех инициатив.');
                break;
            }
        }
    }

    public function getIsMarketParticipant()
    {
        $test = $this->getQuestion()->getTest();

        $codes = ['B3_1', 'B3_2', 'B3_3', 'B3_4', 'B3_5', 'B3_6', 'B3_7', 'B3_8', 'B3_9', 'B3_10', 'B3_11', 'B3_12', 'B3_13', 'B3_14', 'B3_15', 'B3_16'];
        foreach ($codes as $code) {
            $question = Question::model()->byCode($code)->byTestId($test->Id)->find();
            $question->Test = $test;
            $result = $question->Test->getResult()->getQuestionResult($question);
            if (!empty($result) && $result['value'] == 1) {
                return true;
            }
        }
        return false;
    }
} 