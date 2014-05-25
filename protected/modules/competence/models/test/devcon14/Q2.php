<?php
namespace competence\models\test\devcon14;

use \competence\models\form\attribute\RadioValue;

class Q2 extends \competence\models\form\Base
{

    public $other;

    public $other2;

    public $platform;

    public $azure;

    private $values = null;



    /**
     * @return RadioValue[]
     */
    public function getValues() {
        if ($this->values == null) {
            $this->values = [
                'q2_1' => new RadioValue('q2_1', 'Да, уже использую'),
                'q2_2' => new RadioValue('q2_2', 'Планирую использовать'),
                'q2_3' => new RadioValue('q2_3', 'Решение по использованию еще не принято (нужна дополнительная информация)'),
                'q2_4' => new RadioValue('q2_4', 'Не использую, потому что', true),
                'q2_5' => new RadioValue('q2_5', 'Нет, использую другую облачную платформу'),
            ];
        }
        return $this->values;
    }

    private $platforms = null;

    /**
     * @return RadioValue[]
     */
    public function getPlatforms() {
        if ($this->platforms == null) {
            $this->platforms = [];
            $this->platforms['platform_1'] = new RadioValue('platform_1', 'Amazon EC2');
            $this->platforms['platform_2'] = new RadioValue('platform_2', 'Google App Engine');
            $this->platforms['platform_3'] = new RadioValue('platform_3', 'Другую', true);
        }
        return $this->platforms;
    }

    public function rules()
    {
        return [
            ['value, azure, other', 'safe'],
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
            'other2' => $this->other2,
            'azure' => $this->azure
        ];
    }
}
