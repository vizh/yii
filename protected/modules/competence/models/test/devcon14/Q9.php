<?php
namespace competence\models\test\devcon14;

class Q9 extends \competence\models\form\Base
{
    private $questions = null;

    public function getQuestions() {
        if ($this->questions == null) {
            $this->questions = [
                'q9_1' => 'Новостная рассылка для разработчиков «Новости MSDN»',
                'q9_2' => 'Новостная рассылка для ИТ-профессионалов «Новости TechNet»',
                'q9_3' => 'Рассылка Microsoft для стартапов',
                'q9_4' => 'Новости Microsoft для высших учебных заведений',
                'q9_5' => 'Студенческий вестник Microsoft',
            ];
        }
        return $this->questions;
    }

    private $values = null;

    public function getValues() {
        if ($this->values == null) {
            $this->values = [];
            $this->values['yes'] = 'Уже подписан(а)';
            $this->values['want'] = 'Хочу подписаться';
        }
        return $this->values;
    }
}
