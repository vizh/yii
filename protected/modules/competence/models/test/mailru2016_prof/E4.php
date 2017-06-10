<?php
namespace competence\models\test\mailru2016_prof;

use competence\models\Result;

class E4 extends \competence\models\form\Base
{

    public $options = [
        '' => 'Укажите степень доверия',
        5 => 'Полностью доверяю',
        4 => 'Скорее доверяю',
        3 => 'Частично доверяю, частично нет',
        2 => 'Скорее не доверяю',
        1 => 'Абсолютно не доверяю',
    ];

    protected function getBaseQuestionCode()
    {
        return 'E1_1';
    }

    protected $values;

    /**
     * @return array|\competence\models\form\attribute\CheckboxValue[]|null
     */
    public function getValues()
    {
        if ($this->values == null) {
            /** @var \competence\models\form\Multiple $form */
            $form = $this->getBaseQuestion()->getForm();
            $result = $this->getBaseQuestion()->getResult();
            if ($result !== null) {
                $this->values = [];
                foreach ($form->Values as $value) {
                    if (in_array($value->key, $result['value']) && !$value->isUnchecker) {
                        if ($value->isOther) {
                            $value->isOther = false;
                            $value->title = 'Другое (<em>добавлен свой вариант</em>: <strong>' . $result['other'] . '</strong>)';
                        }
                        $this->values[] = $value;
                    }
                }
            } else {
                $this->values = $form->Values;
            }
        }

        return $this->values;
    }

    public function rules()
    {
        return [
            ['value', 'checkAllValidator']
        ];
    }

    public function checkAllValidator($attribute, $params)
    {
        foreach ($this->value as $value) {
            if (empty($value)) {
                $this->addError('value', 'Необходимо оценить степень доверия всем выбранным СМИ.');
                return false;
            }
        }
        return true;
    }

    protected function getInternalExportValueTitles()
    {
        $titles = [];
        /** @var \competence\models\form\Multiple $form */
        $form = $this->getBaseQuestion()->getForm();
        foreach ($form->Values as $value) {
            $titles[] = $value->title;
        }
        return $titles;
    }

    protected function getInternalExportData(Result $result)
    {
        $questionData = $result->getQuestionResult($this->question);
        $data = [];
        /** @var \competence\models\form\Multiple $form */
        $form = $this->getBaseQuestion()->getForm();
        foreach ($form->Values as $value) {
            $key = isset($questionData['value'][$value->key]) ? $questionData['value'][$value->key] : null;
            $data[] = $key !== null ? $this->options[$key] : '';
        }
        return $data;
    }

    public function getNext()
    {
        $a1 = $this->getQuestionByCode('A1');
        $a1Result = $a1->getResult();
        if (empty($a1Result)) {
            return $this->getQuestionByCode('A1');
        } else {
            $a2 = $this->getQuestionByCode('A2');
            $a2Result = $a2->getResult();
            if (empty($a2Result)) {
                return $this->getQuestionByCode('A2');
            }
        }
        return $this->getQuestionByCode('A4');
    }
}
