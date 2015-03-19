<?php
namespace competence\models\test\mdtminsk15;

class Q9 extends \competence\models\form\Base {
    private $questions = null;

    public function getQuestions() {
        if ($this->questions == null) {
            $this->questions = [
                'q9_1' => 'DevCon 2014',
                'q9_2' => 'Russian App Day',
                'q9_3' => 'IT Conference'
            ];
        }
        return $this->questions;
    }

    private $values = null;

    public function getValues() {
        if ($this->values == null) {
            $this->values = [];
            $this->values['online'] = 'Подключался(ась) к трансляции';
            $this->values['offline'] = 'Участвовал(а) лично';
        }
        return $this->values;
    }
}
