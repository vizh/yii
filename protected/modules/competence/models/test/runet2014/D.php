<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 08.09.14
 * Time: 16:33
 */

namespace competence\models\test\runet2014;


use application\components\Exception;
use competence\models\form\Base;
use competence\models\Question;
use competence\models\Result;

class D extends Base
{
    use MarketParticipant;

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
        try {
            $test = $this->getQuestion()->getTest();
            if ($test->getResult())
                $question = Question::model()->byCode('B1')->byTestId($test->Id)->find();
            $question->Test = $test;
            $result = $question->Test->getResult()->getQuestionResult($question);
            $values = $question->getFormData()['Values'];
            foreach ($values as $value) {
                if ($value->key == $result['value'])
                    return $value->title;
            }
        } catch (Exception $e) {
            return '{СЕГМЕНТ}';
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
                $this->addError($attribute, 'Необходимо выбрать ответ для каждого закона.');
                break;
            }
        }
    }

    public function getInternalExportValueTitles()
    {
        $d2 = new D2($this->getQuestion());
        $questions = array_values($d2->getQuestions());
        $titles = [];
        foreach ($questions as $question) {
            $titles[] = implode(': ', $question);
        }
        return $titles;
    }

    public function getInternalExportData(Result $result)
    {
        $d2 = new D2($this->getQuestion());
        $questionData = $result->getQuestionResult($this->question);
        $data = [];
        foreach ($d2->getQuestions() as $key => $question) {
            $data[] = isset($questionData['value'][$key]) ? $questionData['value'][$key] : '';
        }
        return $data;
    }
} 