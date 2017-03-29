<?php
namespace competence\models\test\iior17;

class Q18 extends \competence\models\form\Base {

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
                if (is_array($raw)) {
//                    print_r($raw['type']);
//                    print_r($raw['result']);
//                    exit;
                    if (!is_numeric($raw['type']) && $raw['result'] == 0) {
                        $this->addError($attribute, 'Если указан способ взаимодействовали с органом, необходимо оценить результативность. И&nbsp;наоборот, если указана оценка результативности, просьба указать способ взаимодействия.');
                        return;
                    }
                }
            }
        } else {
            $this->addError($attribute, 'Некорректный формат ответа.');
        }
    }

    protected function getDefinedViewPath()
    {
        return 'competence.views.test.iior17.q18';
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
