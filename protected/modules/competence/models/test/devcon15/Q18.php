<?php
namespace competence\models\test\devcon15;

use competence\models\Result;

class Q18 extends \competence\models\form\Base
{

    private $questions;

    public function getQuestions()
    {
        if ($this->questions == null) {
            $this->questions = [
                'q18_1' => 'Новостная рассылка для разработчиков «Новости MSDN»',
                'q18_2' => 'Новостная рассылка для ИТ-профессионалов «Новости TechNet»',
                'q18_3' => 'Рассылка Microsoft для стартапов',
                'q18_5' => 'Студенческий вестник Microsoft',
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

    /**
     * @return array
     */
    public function getInternalExportValueTitles()
    {
        return array_values($this->getQuestions());
    }

    /**
     * @param Result $result
     * @return array
     */
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
