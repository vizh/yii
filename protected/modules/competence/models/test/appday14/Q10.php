<?php
namespace competence\models\test\appday14;

class Q10 extends \competence\models\form\Base
{
    private $questions = null;

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
