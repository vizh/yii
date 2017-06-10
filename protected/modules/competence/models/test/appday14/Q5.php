<?php
namespace competence\models\test\appday14;

use competence\models\form\attribute\CheckboxValue;
use \competence\models\form\attribute\RadioValue;
use competence\models\Result;

class Q5 extends \competence\models\form\Base
{

    public $other;
    public $other2;
    public $platform;
    private $values;



    /**
     * @return RadioValue[]
     */
    public function getValues() {
        if ($this->values == null) {
            $this->values = [
                'q5_1' => new RadioValue('q5_1', 'Да, уже использую'),
                'q5_2' => new RadioValue('q5_2', 'Планирую использовать'),
                'q5_3' => new RadioValue('q5_3', 'Решение по использованию еще не принято (нужна дополнительная информация)'),
                'q5_4' => new RadioValue('q5_4', 'Не использую, потому что', true),
            ];
        }
        return $this->values;
    }

    private $platforms;

    /**
     * @return RadioValue[]
     */
    public function getPlatforms() {
        if ($this->platforms == null) {
            $this->platforms = [];
            $this->platforms['platform_1'] = new CheckboxValue('platform_1', 'Amazon');
            $this->platforms['platform_2'] = new CheckboxValue('platform_2', 'Google');
            $this->platforms['platform_3'] = new CheckboxValue('platform_3', 'Microsoft Azure');
        }
        return $this->platforms;
    }

    public function rules()
    {
        return [
            ['value, other', 'safe'],
            //['platform', 'platformValidator'],
            //['other', 'otherValidator'],
            //['other2', 'other2Validator'],
        ];
    }

//    public function platformValidator($attribute, $params)
//    {
//        if ($this->value === 'q2_5' && empty($this->platform)) {
//            $this->addError('', 'Выберите одну из облачных платформ или укажите свой вариант');
//            return false;
//        }
//        return true;
//    }

//    public function otherValidator($attribute, $params)
//    {
//        $this->other = trim($this->other);
//        if ($this->value === 'q2_4' && empty($this->other)) {
//            $this->addError('', 'Укажите свой вариант облачной платформы');
//            return false;
//        }
//        return true;
//    }

//    public function other2Validator($attribute, $params)
//    {
//        $this->other2 = trim($this->other2);
//        if ($this->value === 'q2_5' && $this->platform === 'platform_3' && empty($this->other2)) {
//            $this->addError('', 'Укажите свой вариант облачной платформы');
//            return false;
//        }
//        return true;
//    }

    public function checkOtherValidator($attribute, $params)
    {
        foreach ($this->Values as $value)
        {
            if (!in_array($value->key, $this->value) || !$value->isOther)
                continue;
            $this->other = trim($this->other);

            if (empty($this->other))
            {
                $this->addError('', 'Необходимо заполнить текстовое поле "другое"');
                return false;
            }
        }
        return true;
    }

    public function valueValidator($attribute, $params)
    {
        foreach ($this->getQuestions() as $key => $question) {
            $value = isset($this->value[$key]) ? intval($this->value[$key]) : 0;
            if ($value <= 0 || $value > 9) {
                $this->addError('', 'Необходимо оценить мероприятие по всем критериям из списка');
                return false;
            }
        }
        return true;
    }

    protected function getFormData()
    {
        return [
            'value' => $this->value,
            'other' => $this->other,
            'platform' => $this->platform,
            'other2' => $this->other2
        ];
    }

    public function getInternalExportValueTitles()
    {
        $values = [];
        foreach ($this->getValues() as $value) {
            $values[] = $value->title;
            if ($value->key == 'q5_1') {
                foreach ($this->getPlatforms() as $platform) {
                    $values[] = $platform->title;
                }
            }
        }
        return $values;
    }

    public function getInternalExportData(Result $result)
    {
        $questionData = $result->getQuestionResult($this->question);
        $data = [];

        foreach ($this->getValues() as $value) {
            if ($value->key == 'q5_4') {
                $data[] = $questionData['other'];
            }
            else {
                $data[] = $questionData['value'] == $value->key ? 1 : 0;
                if ($value->key == 'q5_1') {
                    foreach ($this->getPlatforms() as $platform) {
                        $data[] = $questionData['platform'] == $platform->key ? 1 : 0;
                    }
                }
            }
        }
        return $data;
    }
}
