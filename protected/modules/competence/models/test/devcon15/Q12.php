<?php
namespace competence\models\test\devcon15;

use \competence\models\form\attribute\RadioValue;
use \competence\models\form\Base;
use competence\models\Result;

class Q12 extends Base
{
    public $q12_value;


    private $values;

    /**
     * @return RadioValue[]
     */
    public function getValues() {
        if ($this->values == null) {
            $this->values = [
                'q12_2' => new RadioValue('q12_2', 'Да', true),
                'q12_1' => new RadioValue('q12_1', 'Нет'),
                'q12_3' => new RadioValue('q12_3', 'Не знаю'),
            ];
        }
        return $this->values;
    }

    private $q12Values;

    /**
     * @return RadioValue[]
     */
    public function getQ12Values() {
        if ($this->q12Values == null) {
            $this->q12Values = [];
            $this->q12Values['q12value_1'] = new RadioValue('q12value_1', 'Консьюмерские (b2c) для взаимодействия с внешними потребителями, заказчиками');
            $this->q12Values['q12value_2'] = new RadioValue('q12value_2', 'Коммерческие (b2b) для автоматизации внутренних процессов в организации');
        }
        return $this->q12Values;
    }

    public function rules()
    {
        return [
            ['value', 'safe'],
            ['q12_value', 'q12Validator'],
        ];
    }

    /**
     * @return array
     */
    protected function getFormData()
    {
        return [
            'value' => $this->value,
            'q12_value' => $this->q12_value
        ];
    }

    public function q12Validator($attribute, $params)
    {
        if ($this->value === 'q12_2' && empty($this->q12_value)) {
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
            if ($value->key == 'q12_2') {
                foreach ($this->getQ12Values() as $q12Value) {
                    $result[] = $q12Value->title;
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
            if ($key == 'q12_2') {
                foreach ($this->getQ12Values() as $q12Key => $q12Value) {
                    $data[] = $questionData['q12_value'] == $q12Key ? '1' : '0';
                }
            }
        }
        return $data;
    }
}
