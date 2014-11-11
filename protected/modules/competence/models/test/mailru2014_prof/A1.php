<?php
namespace competence\models\test\mailru2014_prof;

class A1 extends \competence\models\form\Base {

    private $options = null;

    public function getOptions()
    {
        if ($this->options === null)
        {
            $this->options = $this->rotate('A1_opt', [
                39 => '39.png',
                40 => '40.png',
                41 => '41.png',
                42 => '42.png',
                43 => '43.png',
                44 => '44.png',
                45 => '45.png',
                46 => '46.png',
                47 => '47.png',
                48 => '48.png',
                400 => '400.png',
                401 => '401.png',
                403 => '403.jpg',
                404 => '404.jpeg',
                405 => '405.jpg',
                406 => '406.jpg',
                407 => '407.jpg',
                408 => '408.jpg'
            ]);
            $this->options[49] = 'unknow.png';
        }
        return $this->options;
    }

    public function rules()
    {
        return [
            ['value', 'required', 'message' => 'Отметьте, кого вы знаете, или выберите вариант затрудняюсь ответить.']
        ];
    }

    public function getPrev()
    {
        $e1 = $this->getQuestionByCode('E1');
        if (in_array(99, $e1->getResult()['value']))
        {
            return $e1;
        }
        else
        {
            $e1_1 = $this->getQuestionByCode('E1_1');
            if (in_array(99, $e1_1->getResult()['value']))
            {
                return $e1_1;
            }
        }
        return parent::getPrev();
    }

    public function getNext()
    {
        if (isset($this->value[49]))
        {
            return $this->getQuestionByCode('A4');
        }
        return parent::getNext();
    }


}
