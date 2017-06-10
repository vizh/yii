<?php
namespace competence\models\test\devcon15;

use competence\models\Result;

class Q2 extends \competence\models\form\Base
{
    public $other;

    private $questions;

    public function getQuestions()
    {
        if ($this->questions == null) {
            $this->questions = [
                'q2_1'  => 'Организация мероприятия в целом',
                'q2_2'  => 'Процесс регистрации участников на месте проведения (получение бейджей)',
                'q2_3'  => 'Организация, качество и количество питания',
                'q2_4'  => 'Качество расселения в отеле, соответствие вашим пожеланиям и ожиданиям',
                'q2_5'  => 'Качество номеров и проживания в природном курорте «Яхонты»',
                'q2_6'  => 'Насколько для вас оказалось полезным посещение шатра «Гостевой дом Microsoft»',
                'q2_7'  => 'Выставка партнеров конференции в фойе Конгресс-Холла',
                'q2_8'  => 'Информационный пакет участника',
                'q2_9'  => 'Работа помощников (event-team)',
                'q2_10' => 'Работа колл-центра конференции по организационным вопросам',
                'q2_11' => 'Работа колл-центра конференции по вопросам оплаты',
                'q2_12' => 'Трансфер на конференцию (бесплатные автобусы, маршрутные такси)',
                'q2_13' => 'Удобство сайта конференции',
                'q2_14' => 'Удобство регистрации и выставления счетов на сайте конференции',
                'q2_15' => 'Развлекательные активности (квест, игры и т.д.)',
                'q2_16' => 'Выступление музыкальной группы на вечерней программе в первый день конференции',
                'q2_17' => 'Качество синхронного перевода англоязычных докладов',
                'q2_18' => 'Качество и доступность подключения к WiFi сети конференции',
                'q2_19' => 'Удобство и качество официального приложения конференции',
                'q2_20' => 'Визуальное оформление конференции («Мир живого кода»)',
                'q2_21' => 'Понравилось ли вам мероприятие в целом',
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

    /**
     * @return array
     */
    public function getInternalExportValueTitles()
    {
        $result = array_values($this->getQuestions());
        $result[] = 'Ваши комментарии и пожелания по организационным вопросам конференции';
        return $result;
    }

    /**
     * @param Result $result
     * @return array
     */
    public function getInternalExportData(Result $result)
    {
        $questionData = $result->getQuestionResult($this->question);
        $data = [];
        foreach ($this->getQuestions() as $key => $market) {
            $data[] = isset($questionData['value'][$key]) ? $questionData['value'][$key] : '';
        }
        $data[] = $questionData['other'];
        return $data;
    }
}
