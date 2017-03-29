<?php
namespace competence\models\test\iior17;

class Q9 extends \competence\models\form\Base {

    public $subMarkets = [
        'Федеральная налоговая служба',
        'Министерство внутренних дел',
        'Министерство экологии Республики Татарстан',
        'Роспотребнадзор',
        'Росимущество',
        'Росреестр',
        'Пенсионный фонд',
        'Федеральная миграционная служба',
        'ГИБДД',
        'Министерство экономики Республики Татарстан',
        'Ведомства, предоставляющие услуги лицензирования',
        'Уполномоченный при Президенте РТ по защите прав предпринимателей',
        'Служба государственной статистики',
        'Министерство информации и связи РТ'
    ];

    public function rules()
    {
        return [
            ['value', 'validateValue']
        ];
    }

    public function validateValue($attribute, $params)
    {

        if (is_array($this->$attribute)) {
            foreach ($this->$attribute as $raw) {
                $val = trim($raw);
                if (strlen($val) == 0 || $val < 0) {
                    $this->addError($attribute, 'Ничего не выбрано, так нельзя.');
                    return;
                } elseif (!is_numeric($val) || $val > 5) {
                    $this->addError($attribute, 'Некорректный формат ответа.');
                    return;
                }
            }
        } else {
            $this->addError($attribute, 'Некорректный формат ответа.');
        }
    }

    protected function getDefinedViewPath()
    {
        return 'competence.views.test.iior17.q9';
    }

    public function getInternalExportValueTitles()
    {
        return array_values($this->subMarkets);
    }

    public function getInternalExportData(Result $result)
    {
        $questionData = $result->getQuestionResult($this->question);
        $data = [];
        foreach ($this->subMarkets as $key => $market) {
            $data[] = isset($questionData['value'][$key]) ? $questionData['value'][$key] : '';
        }
        return $data;
    }

}
