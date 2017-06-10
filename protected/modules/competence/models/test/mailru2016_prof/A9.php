<?php
namespace competence\models\test\mailru2016_prof;

use competence\models\Result;

class A9 extends \competence\models\form\Base
{

    public $value = [];

    public $other;

    protected function getBaseQuestionCode()
    {
        return 'A8';
    }

    protected $options;

    public function getOptions()
    {
        return $this->getBaseQuestion()->getForm()->getOptions();
    }

    public function rules()
    {
        return [
            ['value', 'required', 'message' => 'Выберите хотя бы один ответ из списка'],
            ['value', 'otherSelectionValidator']
        ];
    }

    public function otherSelectionValidator($attribute, $params)
    {
        if (in_array(98, $this->value) && strlen(trim($this->other)) == 0) {
            $this->addError('Other', 'При выборе варианта "Другое" необходимо вписать свой вариант компании');
            return false;
        }
        return true;
    }

    protected function getFormData()
    {
        return ['value' => $this->value, 'other' => $this->other];
    }

    protected function getInternalExportValueTitles()
    {
        $titles = $this->getOptions();
        $titles['other'] = 'Другое - значение';
        return array_values($titles);
    }

    protected function getInternalExportData(Result $result)
    {
        $titles = $this->getOptions();
        $keys = array_keys($titles);
        $questionData = $result->getQuestionResult($this->question);
        $data = [];
        foreach ($keys as $key) {
            $data[] = !empty($questionData['value']) && in_array($key, $questionData['value']) ? 1 : '';
            if ($key == 98) {
                $data[] = $questionData['other'];
            }
        }
        return $data;
    }
}
