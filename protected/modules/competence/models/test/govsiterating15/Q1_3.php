<?php
namespace competence\models\test\govsiterating15;

use competence\models\Result;

class Q1_3 extends \competence\models\form\Base
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['value', 'validateValue']
        ];
    }

    /**
     * @param string $attribute
     * @return bool
     */
    public function validateValue($attribute)
    {
        $value = $this->$attribute;
        $valid = true;
        foreach ($this->getPairValues() as $key => $pair) {
            if (empty($value[$key]) || !in_array($value[$key], [1,2])) {
                $valid = false;
                break;
            }
        }

        if (!$valid) {
            $this->addError($attribute, 'Выберите значение во всех парах определений, характеризующих сайт');
        }
        return $valid;
    }


    public function getPairValues()
    {
        return [
            [1 => 'Устаревший', 2 => 'Современный'],
            [1 => 'Эффективный', 2 => 'Неэффективный'],
            [1 => 'Неудобный', 2 => 'Удобный'],
            [1 => 'Чистый', 2 => 'Замусоренный'],
            [1 => 'Привлекательный', 2 => 'Непривлекательный'],
            [1 => 'Любительский', 2 => 'Профессиональный'],
            [1 => 'Скучный', 2 => 'Интересный'],
            [1 => 'Бесполезный', 2 => 'Полезный'],
            [1 => 'Качественный', 2 => 'Халтурный'],
            [1 => 'Сложный', 2 => 'Простой'],
            [1 => 'Дружественный', 2 => 'Недружественный'],
            [1 => 'Раздражающий', 2 => 'Комфортабельный'],
            [1 => 'Прямой', 2 => 'Запутанный'],
            [1 => 'Головоломный', 2 => 'Интуитивный'],
            [1 => 'Содержательный', 2 => 'Пустой']
        ];
    }

    public function getPrev()
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function getBtnNextLabel()
    {
        return 'Отправить результаты';
    }

    /**
     * @return array
     */
    public function getInternalExportValueTitles()
    {
        return array_fill(0, count($this->getPairValues()), '');
    }

    /**
     * @param Result $result
     * @return array
     */
    public function getInternalExportData(Result $result)
    {
        $questionData = $result->getQuestionResult($this->question);
        if (!empty($questionData['value'])) {
            $data = [];
            foreach ($questionData['value'] as $i => $val) {
                $data[] = $this->getPairValues()[$i][$val];
            }
            return $data;
        } else {
            return array_fill(0, count($this->getPairValues()), '-');
        }
    }
}
