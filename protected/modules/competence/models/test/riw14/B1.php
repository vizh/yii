<?php
namespace competence\models\test\riw14;

class B1 extends \competence\models\form\Base 
{
	public function getQuestions()
	{
		return [
			1 => 'Общий уровень RIW 2014',
			2 => 'Уровень выставки ИНТЕРНЕТ 2014 в рамках RIW',
			3 => 'Уровень выставки Softool 2014',
			4 => 'Состав докладчиков конференционной программы Медиа-коммуникационного Форума в рамках RIW 2014',
			5 => 'Актуальность, новизна докладов',
			6 => 'Было ли для Вас полезным посещение Выставки и стендов компаний-экспонентов?',
			7 => 'Уровень подготовки и проведения Спецмероприятий, промо-акций во время перерывов и вечерней программы RIW-Night'
		];
	}

    /**
     * @return array
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            ['value', 'validateValue']
        ]);
    }

    public function validateValue($attribute)
    {
        $valid = true;

        $value = $this->$attribute;
        foreach ($this->getQuestions() as $key => $question) {
            if (!isset($value[$key]) || empty($value[$key])) {
                $valid = false;
            }
        }

        if (!$valid) {
            $this->addError($attribute, 'Пожалуйста, укажите ответ на все вопросы!');
        }
    }
}
