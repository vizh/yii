<?php
namespace competence\models\test\mailru2016_prof;

use competence\models\Result;

class A1 extends \competence\models\form\Base {

    private $options = null;

    public function getOptions()
    {
        if ($this->options === null)
        {
            $this->options = $this->rotate('A1_opt', [
                40 => '40.jpg',
                41 => '41.png',
                42 => '42.png',
                43 => '43.png',
                44 => '44.png',
                46 => '46.png',
                47 => '47.png',
                48 => '48.png',
                401 => '401.png',
                403 => '403.jpg',
                404 => '404.jpg',
                405 => '405.jpg',
                406 => '406.jpg',
                407 => '407.jpg',
                408 => '408.jpg',
                409 => '409.jpg',
                410 => '410.jpg', //Волож,
                411 => '411.jpg', //Касперская,
                412 => '412.jpg', //Брин,
                413 => '413.jpg'  //Ян
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

    protected function getInternalExportValueTitles()
    {
        $titles = [
            40, 41, 42, 43, 44, 46, 47, 48, 401, 403, 404, 405, 406, 407, 408, 409, 410, 411, 412, 413, 'Затрудняюсь ответить'
        ];
        return $titles;
    }

    protected function getInternalExportData(Result $result)
    {
        $titles = [
            40, 41, 42, 43, 44, 46, 47, 48, 401, 403, 404, 405, 406, 407, 408, 409, 410, 411, 412, 413, 49
        ];
        $questionData = $result->getQuestionResult($this->question);
        $data = [];
        foreach ($titles as $key) {
            $data[] = isset($questionData['value'][$key]) ? 1 : '';
        }
        return $data;
    }
}
