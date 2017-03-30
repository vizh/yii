<?php
namespace competence\models\test\iior17;

class Q18 extends \competence\models\form\Base {

    public $subMarkets = [
        'Президент Республики Татарстан',
        'Правительство Республики Татарстан',
        'Министерства, государственные комитеты Правительства Республики Татарстан',
        'Государственный Совет Республики Татарстан',
        'Муниципальные образования Республики Татарстан',
        'Местные законодательные органы власти',
        'Пенсионный фонд по Республике Татарстан',
        'Управление Федеральной налоговой службы по Республике Татарстан',
        'Министерство внутренних дел по Республике Татарстан',
        'Управление Федеральной миграционной службы по Республике Татарстан',
        'Роспотребнадзор по Республике Татарстан',
        'Росимущество по Республике Татарстан',
        'Росреестр по Республике Татарстан',
        'Федеральные агентства по Республике Татарстан'
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
