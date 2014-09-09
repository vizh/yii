<?php
namespace competence\models\test\runet2014;

use application\components\Exception;
use competence\models\Question;

class D2 extends D
{
    private $values = null;
    public function getValues()
    {
        if ($this->values == null) {
            $this->values = ['' => '-'];
            $this->values['full'] = 'Полностью знаком(-а) с текстом';
            $this->values['part'] = 'Знаком(-а) с текстом частично, читал(-а) его отдельные положения';
            $this->values['understand'] = "С текстом не знаком(-а), однако что-то слышал о нем из разных источников (мнения коллег, комментарии в СМИ и т.д.)";
            $this->values['not'] = 'Не слышал ранее об этой законодательной инициативе';
        }
        return $this->values;
    }

    private $questions = null;
    public function getQuestions()
    {
        if ($this->questions == null) {
            $this->questions = [
                'd2_1' => ['187-ФЗ', 'Антипиратский закон'],
                'd2_2' => ['97-ФЗ', 'Блогерский закон'],
                'd2_3' => ['398-ФЗ', 'Борьба с экстремизмом в интернете'],
                'd2_4' => ['101-ФЗ', 'Запрет мата'],
                'd2_5' => ['242-ФЗ', 'Ограничения на хранение персональных данных за пределами РФ'],
                'd2_6' => ['115-ФЗ', 'Ограничения на интернет-платежи']
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
        for ($i=16; $i>=1; $i--) {
            if (in_array($i, $resultB2['value'])) {
                return Question::model()->byCode('C10A_'.$i)->byTestId($this->getQuestion()->TestId)->find();
            }
        }
        throw new Exception('Ошибка при получении предыдущего вопроса в D2');
        return null;
    }


    public function getNext()
    {
        foreach ($this->value as $value) {
            if ($value !== 'not') {
                if (!$this->getIsMarketParticipant($this->getQuestion()->Test)) {
                    $question = Question::model()->byCode('D4')->byTestId($this->getQuestion()->TestId)->find();
                    $question->Test = $this->getQuestion()->getTest();
                    return $question;
                }
                return parent::getNext();
            }
        }

        $question = Question::model()->byCode('D7')->byTestId($this->getQuestion()->TestId)->find();
        $question->Test = $this->getQuestion()->getTest();
        return $question;
    }
}
