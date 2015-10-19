<?php
namespace competence\models\test\iidf15;

use competence\models\form\Input;
use competence\models\Result;

class Q2 extends Input
{
    public $valuePhone;

    public function rules()
    {
        return [
            ['value,valuePhone', 'filter', 'filter' => '\application\components\utility\Texts::clear']
        ];
    }

    /**
     * @return string
     * @throws \application\components\Exception
     */
    protected function getDefinedViewPath()
    {
        return 'competence.views.test.' . $this->getQuestion()->getTest()->Code . '.q2';
    }

    /**
     * @return array
     */
    protected function getFormData()
    {
        return [
            'value' => $this->value,
            'valuePhone' => $this->valuePhone
        ];
    }

    /**
     * @param Result $result
     */
    public function getInternalExportData(Result $result)
    {
        $data = $result->getResultByData()['Q2'];
        return [
            $data['value'],
            $data['valuePhone']
        ];
    }

    /**
     * @return array
     */
    public function getInternalExportValueTitles()
    {
        return [
            'Имя Фамилия',
            'Телефон'
        ];
    }


}
