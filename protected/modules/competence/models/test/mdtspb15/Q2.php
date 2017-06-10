<?php
namespace competence\models\test\mdtspb15;

use \competence\models\form\attribute\RadioValue;
use \competence\models\form\Base;
use competence\models\Result;

class Q2 extends Base
{
    public $q2_value;


    private $values;

    /**
     * @return RadioValue[]
     */
    public function getValues() {
        if ($this->values == null) {
            $this->values = [
                'q2_2' => new RadioValue('q2_2', 'Да', true),
                'q2_1' => new RadioValue('q2_1', 'Нет'),
                'q2_3' => new RadioValue('q2_3', 'Не знаю'),
            ];
        }
        return $this->values;
    }

    private $q2Values;

    /**
     * @return RadioValue[]
     */
    public function getQ2Values() {
        if ($this->q2Values == null) {
            $this->q2Values = [];
            $this->q2Values['q2value_1'] = new RadioValue('q2value_1', 'Консьюмерские (b2c) для взаимодействия с внешними потребителями, заказчиками');
            $this->q2Values['q2value_2'] = new RadioValue('q2value_2', 'Коммерческие (b2b) для автоматизации внутренних процессов в организации');
        }
        return $this->q2Values;
    }

    public function rules()
    {
        return [
            ['value', 'safe'],
            ['q2_value', 'q2Validator'],
        ];
    }

    /**
     * @return array
     */
    protected function getFormData()
    {
        return [
            'value' => $this->value,
            'q2_value' => $this->q2_value
        ];
    }

    public function q2Validator($attribute, $params)
    {
        if ($this->value === 'q2_2' && empty($this->q2_value)) {
            $this->addError('', 'Выберите один из типов разрабатываемых приложений');
            return false;
        }
        return true;
    }

    /**
     * @return array
     */
    public function getInternalExportValueTitles()
    {
        $result = [];
        foreach($this->getValues() as $value) {
            $result[] = $value->title;
            if ($value->key == 'q2_2') {
                foreach ($this->getQ2Values() as $q2Value) {
                    $result[] = $q2Value->title;
                }
            }
        }
        return $result;
    }

    /**
     * @param Result $result
     * @return array
     */
    public function getInternalExportData(Result $result)
    {
        $questionData = $result->getQuestionResult($this->question);
        $data = [];
        foreach($this->getValues() as $key => $value) {
            $data[] = $questionData['value'] == $key ? '1' : '0';
            if ($key == 'q2_2') {
                foreach ($this->getQ2Values() as $q2Key => $q2Value) {
                    $data[] = $questionData['q2_value'] == $q2Key ? '1' : '0';
                }
            }
        }
        return $data;
    }
}
