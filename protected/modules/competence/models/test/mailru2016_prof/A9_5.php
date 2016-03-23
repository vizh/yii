<?php
namespace competence\models\test\mailru2016_prof;

use competence\models\form\attribute\CheckboxValue;
use \competence\models\form\Base;
use competence\models\Result;

class A9_5 extends Base
{
    protected function getBaseQuestionCode()
    {
        return 'E1_1';
    }

    public $options = [
        '' => 'Укажите регулярность проведения мероприятий',
        1 => 'Очень часто',
        2 => 'Скорее часто',
        3 => 'Скорее редко',
        4 => 'Очень редко',
        5 => 'Затрудняюсь ответить'
    ];

    protected $values = null;

    /**
     * @return array|\competence\models\form\attribute\CheckboxValue[]|null
     */
    public function getValues()
    {
        $titles = [
            1 => 'Mail.Ru Group (включая Одноклассники и ВКонтакте)',
            2 => 'Яндекс',
            3 => 'Google',
            4 => 'Rambler&Co',
            5 => 'Microsoft',
            6 => 'Kaspersky',
            7 => 'Parallels'
        ];

        $values = [];
        foreach ($titles as $key => $title) {
            $values[] = new CheckboxValue($key, $title);
        }
        return $values;
    }

    public function rules()
    {
        return [
            ['value', 'checkAllValidator']
        ];
    }

    /**
     * @param $attribute
     * @param $params
     * @return bool
     */
    public function checkAllValidator($attribute, $params)
    {
        foreach ($this->value as $value) {
            if (empty($value)) {
                $this->addError('value', 'Необходимо оценить регулярность проведения мероприятий для всех компаний.');
                return false;
            }
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    protected function getInternalExportValueTitles()
    {
        return [
            'Mail.Ru Group (включая Одноклассники и ВКонтакте)',
            'Яндекс',
            'Google',
            'Rambler&Co',
            'Microsoft',
            'Kaspersky',
            'Parallels'
        ];
    }

    protected function getInternalExportData(Result $result)
    {
        $keys = [1,2,3,4,5,6,7];
        $questionData = $result->getQuestionResult($this->question);

        $data = [];
        foreach ($keys as $key) {
            $data[] = !empty($questionData['value']) && isset($questionData['value'][$key]) ? $this->options[$questionData['value'][$key]] : '';
        }
        return $data;
    }


}
