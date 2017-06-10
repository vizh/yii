<?php
namespace competence\models\test\devcon14;

class Q8 extends \competence\models\form\Base
{
    private $questions;

    public function getQuestions() {
        if ($this->questions == null) {
            $this->questions = [
                'q8_1' => 'Windows Camp',
                'q8_2' => 'AppsMafia Hackathon',
                'q8_3' => 'Cloud OS Summit',
                'q8_4' => 'Design Camp',
                'q8_5' => 'ALM Summit',
                'q8_6' => 'AppSummit',
                'q8_7' => 'DevCon 2013',
            ];
        }
        return $this->questions;
    }

    private $values;

    public function getValues() {
        if ($this->values == null) {
            $this->values = [];
            $this->values['online'] = 'Подключался(ась) к трансляции';
            $this->values['offline'] = 'Участвовал(а) лично';
        }
        return $this->values;
    }
}
