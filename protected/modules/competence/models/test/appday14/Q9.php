<?php
namespace competence\models\test\appday14;

use competence\models\Result;

class Q9 extends \competence\models\form\Base
{
    private $questions;

    public function getQuestions() {
        if ($this->questions == null) {
            $this->questions = [
                'q9_1' => 'Windows Camp',
                'q9_2' => 'Cloud OS Summit',
                'q9_3' => 'Design Camp',
                'q9_4' => 'ALM Summit',
                'q9_5' => 'DevCon 2014',
                'q9_6' => 'Office 365 Summit'
            ];
        }
        return $this->questions;
    }

    private $values;

    public function getValues() {
        if ($this->values == null) {
            $this->values = [];
            $this->values['connect'] = 'Подключался(ась) к трансляции';
            $this->values['participant'] = 'Участвовал(а) лично';
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
