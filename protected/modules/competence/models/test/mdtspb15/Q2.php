<?php
namespace competence\models\test\mdtspb15;

use \competence\models\form\attribute\RadioValue;
use \competence\models\form\Base;

class Q2 extends Base
{
    public $q2_value;


    private $values = null;

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

    private $q2Values = null;

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
}
