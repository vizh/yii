<?php
namespace application\components\validators;

class MultipleFormValidator extends \CValidator
{
    public $when = null;

    protected function validateAttribute($object, $attribute)
    {
        $value = $object->$attribute;
        if (!is_array($value)) {
            $object->addError($attribute, \Yii::t('app', 'Неверное значение {attribute}.', ['{attribute}' => $object->getAttributeLabel($attribute)]));
            return false;
        }

        $valid = true;

        /** @var \CFormModel $form */
        foreach ($value as $form) {
            if ($this->when instanceof \Closure && !call_user_func($this->when, $form)) {
                continue;
            }
            if (!$form->validate()) {
                $valid = false;
            }
        }

        if (!$valid) {
            $object->addError($attribute, \Yii::t('app', 'Ошибка при заполнении {attribute}.', ['{attribute}' => $object->getAttributeLabel($attribute)]));
            return false;
        }
        return true;
    }
}