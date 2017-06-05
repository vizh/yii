<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 08.10.2015
 * Time: 15:37
 */

namespace application\components\validators;

class RangeValidator extends \CRangeValidator
{
    protected function validateAttribute($object, $attribute)
    {
        $value = $object->$attribute;
        if ($this->allowEmpty && $this->isEmpty($value)) {
            return;
        }

        if (!is_array($this->range)) {
            throw new \CException(\Yii::t('yii', 'The "range" property must be specified with a list of values.'));
        }

        if (!is_array($value)) {
            $value = [$value];
        }

        foreach ($value as $val) {
            if (!$this->not && !in_array($val, $this->range, $this->strict)) {
                $message = $this->message !== null ? $this->message : \Yii::t('yii', '{attribute} is not in the list.');
                $this->addError($object, $attribute, $message);
                break;
            } elseif ($this->not && in_array($val, $this->range, $this->strict)) {
                $message = $this->message !== null ? $this->message : \Yii::t('yii', '{attribute} is in the list.');
                $this->addError($object, $attribute, $message);
                break;
            }
        }
    }
}