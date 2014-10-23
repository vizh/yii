<?php
namespace competence\models\test\userexp14;

use competence\models\Result;

class Q6 extends \competence\models\form\Base
{
    public function rules()
    {
        return [
            ['value', 'validateValue']
        ];
    }

    public function validateValue($attribute, $params)
    {
        if (empty($this->value['place1']) || empty($this->value['place2']) || empty($this->value['place3']))
            $this->addError($attribute, 'Необходимо ввести названия всех трех докладов');
    }

    protected function getDefinedViewPath()
    {
        return 'competence.views.test.userexp14.q6';
    }

    public function getInternalExportValueTitles()
    {
        return ['Доклад 1', 'Доклад 2', 'Доклад 3'];
    }

    public function getInternalExportData(Result $result)
    {
        $data = $result->getQuestionResult($this->question);
        return !empty($data) ? [$data['value']['place1'], $data['value']['place2'], $data['value']['place3']] : ['', '', ''];
    }
}
