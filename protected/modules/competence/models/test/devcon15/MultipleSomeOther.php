<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 07.05.2015
 * Time: 13:46
 */

namespace competence\models\test\devcon15;


use competence\models\form\Multiple;

abstract class MultipleSomeOther extends Multiple
{
    /**
     * @param $attribute
     * @param $params
     * @return bool
     */
    public function checkOtherValidator($attribute, $params)
    {
        foreach ($this->Values as $value)
        {
            if (!in_array($value->key, $this->value) || !$value->isOther)
                continue;

            $otherName = 'other_'.$value->key;
            $other = trim($this->$otherName);
            if (empty($other)) {
                $this->addError('', 'Необходимо заполнить текстовое поле рядом с вариантом ответа');
                return false;
            }
        }
        return true;
    }

    /**
     * @inheritdoc
     */
    protected function getDefinedViewPath()
    {
        return 'competence.views.test.devcon15.multiple_some_other';
    }
} 