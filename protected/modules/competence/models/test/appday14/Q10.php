<?php
namespace competence\models\test\appday14;

use competence\models\Result;

class Q10 extends \competence\models\form\Base
{
    private $questions;

    public function getQuestions() {
        if ($this->questions == null) {
            $this->questions = [
                'q10_1' => 'Новостная рассылка для разработчиков «Новости MSDN»',
                'q10_2' => 'Новостная рассылка для ИТ-профессионалов «Новости TechNet»',
                'q10_3' => 'Рассылка Microsoft для стартапов',
                'q10_4' => 'Студенческий вестник Microsoft',
            ];
        }
        return $this->questions;
    }

    private $values;

    public function getValues() {
        if ($this->values == null) {
            $this->values = [];
            $this->values['yes'] = 'Уже подписан(а)';
            $this->values['want'] = 'Хочу подписаться';
        }
        return $this->values;
    }


    public function getInternalExportValueTitles()
    {
        return array_values($this->getQuestions());
    }

    public function getInternalExportData(Result $result)
    {
        $questionData = $result->getQuestionResult($this->question);
        $data = [];
        foreach ($this->getQuestions() as $key => $question) {
            $data[] = $this->getValues()[$questionData['value'][$key]];
        }
        return $data;
    }
}
