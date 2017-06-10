<?php
namespace competence\models\test\runet2015;

use competence\models\form\Base;
use competence\models\Question;
use competence\models\Result;

class D1 extends Base{

    public $questions;

    public function rules()
    {
        return [
            ['value', 'validateValue']
        ];
    }

    /**
     * @param $attribute
     * @return bool
     */
    public function validateValue($attribute) {
        $value = $this->$attribute;
        foreach ($this->getQuestions() as $key => $label) {
            if (!isset($value[$key]) || $value[$key] == '') {
                $this->addError($attribute, 'Укажите оценку влияния для всех вопросов.');
                return false;
            }
        }
        return true;
    }


    /**
     * @return array
     * @throws \application\components\Exception
     */
    public function getQuestions()
    {
        if ($this->questions == null) {
            $test =  $this->getQuestion()->Test;
            $question = Question::model()->byTestId($test->Id)->byCode('B1')->find();
            $question->setTest($test);
            $result = $question->getResult();

            $b1 = new B1($question);
            $segment = null;
            foreach ($b1->Values as $value) {
                if ($value->key == $result['value']) {
                    $segment = $value->title;
                    break;
                }
            }

            $this->questions = [
                'd1_1' => '...влияния экономического кризиса на экономику России в 2014 году.',
                'd1_2' => '...влияния экономического кризиса на российские интернет-рынки в 2014 году.',
                'd1_3' => '...влияния экономического кризиса на российский сегмент «' . $segment . '»  в 2014 году.',
                'd1_4' => '...прогозируемого влияния экономического кризиса на экономику России в 2015 году.',
                'd1_5' => '...прогнозируемого влияния экономического кризиса на российские интернет-рынки в 2015 году.',
                'd1_6' => '...прогнозируемого влияния экономического кризиса на российский сегмент «' . $segment . '»  в 2015 году.'
            ];
        }
        return $this->questions;
    }

    public function getPrev()
    {
        $b1 = Question::model()->byCode('B1')->byTestId($this->getQuestion()->TestId)->find();
        $b1->Test = $this->getQuestion()->getTest();
        $resultB1 = $b1->getResult();

        $b2 = Question::model()->byCode('B2_'.$resultB1['value'])->byTestId($this->getQuestion()->TestId)->find();
        $b2->Test = $this->getQuestion()->getTest();
        $resultB2 = $b2->getResult();

        for ($i=17; $i>=1; $i--) {
            if (in_array($i, $resultB2['value'])) {
                $question = Question::model()->byCode('C9_'.$i)->byTestId($this->getQuestion()->TestId)->find();
                if ($question == null) {
                    $question = Question::model()->byCode('C8_'.$i)->byTestId($this->getQuestion()->TestId)->find();
                }
                return $question;
            }
        }
        throw new Exception('Ошибка при получении предыдущего вопроса в D2');
        return null;
    }

    /**
     * @return array
     */
    protected function getInternalExportValueTitles()
    {
        $titles = [];

        $test = $this->getQuestion()->Test;
        $question = Question::model()->byTestId($test->Id)->byCode('B1')->find();
        $question->setTest($test);

        $b1 = new B1($question);
        foreach ($b1->Values as $value) {
            $titles = array_merge($titles, [
                'Сегмент: «' . $value->title . '», ...влияния экономического кризиса на экономику России в 2014 году.',
                'Сегмент: «' . $value->title . '», ...влияния экономического кризиса на российские интернет-рынки в 2014 году.',
                'Сегмент: «' . $value->title . '», ...влияния экономического кризиса на российский сегмент «' . $value->title . '»  в 2014 году.',
                'Сегмент: «' . $value->title . '», ...прогозируемого влияния экономического кризиса на экономику России в 2015 году.',
                'Сегмент: «' . $value->title . '», ...прогнозируемого влияния экономического кризиса на российские интернет-рынки в 2015 году.',
                'Сегмент: «' . $value->title . '», ...прогнозируемого влияния экономического кризиса на российский сегмент «' . $value->title . '»  в 2015 году.'
            ]);
        }
        return $titles;
    }

    /**
     * @param Result $result
     * @return array
     */
    protected function getInternalExportData(Result $result)
    {
        $data = [];

        $test = $this->getQuestion()->getTest();
        $test->setUser($result->User);

        $b1Question = Question::model()->byTestId($test->Id)->byCode('B1')->find();
        $b1Question->setTest($test);

        $resultB1 = $result->getResultByData()['B1'];

        $questionData = $result->getQuestionResult($this->question);

        $b1 = new B1($b1Question);
        foreach ($b1->Values as $value) {
            if ($value->key == $resultB1['value'] && !empty($questionData['value'])) {
                $data = array_merge($data, array_values($questionData['value']));
            } else {
                $data = array_merge($data, ['','','','','', '']);
            }
        }
        return $data;
    }


}
