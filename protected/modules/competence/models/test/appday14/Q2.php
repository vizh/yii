<?php
namespace competence\models\test\appday14;

use competence\models\Result;

class Q2 extends \competence\models\form\Base
{
    public $other;

    private $questions;

    public function getQuestions()
    {
        if ($this->questions == null) {
            $this->questions = [
                'q10_1' => 'Организация мероприятия в целом',
                'q10_2' => 'Процесс регистрации участников на месте проведения (получение бейджей)',
                'q10_3' => 'Организация, качество и количество питания',
                'q10_4' => 'Насколько для вас оказалось полезным посещение выставки партнеров',
                'q10_5' => 'Работа помощников (event-team)',
                'q10_6' => 'Работа колл-центра конференции по вопросам оплаты',
                'q10_7' => 'Удобство сайта конференции',
                'q10_8' => 'Удобство регистрации и выставления счетов на сайте конференции',
                'q10_9' => 'Качество и доступность подключения к WiFi сети конференции',
                'q10_10' => 'Понравилось ли вам мероприятие в целом',
            ];
        }
        return $this->questions;
    }

    private $values = ['0' => '-', '9' => '9', '8' => '8', '7' => '7', '6' => '6', '5' => '5', '4' => '4', '3' => '3', '2' => '2', '1' => '1', '10' => 'Не знаю'];

    public function getValues()
    {
        return $this->values;
    }

    public function rules()
    {
        return [
            ['value', 'valueValidator'],
        ];
    }

    public function valueValidator($attribute, $params)
    {
        foreach ($this->getQuestions() as $key => $question) {
            $value = isset($this->value[$key]) ? intval($this->value[$key]) : 0;
            if ($value <= 0 || $value > 10) {
                $this->addError('', 'Необходимо оценить мероприятие по всем критериям из списка');
                return false;
            }
        }
        return true;
    }

    protected function getFormData()
    {
        return [
            'value' => $this->value,
            'other' => $this->other
        ];
    }

    public function getInternalExportValueTitles()
    {
        return array_values($this->getQuestions());
    }

    public function getInternalExportData(Result $result)
    {
        $questionData = $result->getQuestionResult($this->question);
        $data = [];
        foreach ($this->getQuestions() as $key => $market) {
            $data[] = isset($questionData['value'][$key]) ? $questionData['value'][$key] : '';
        }
        return $data;
    }

}
