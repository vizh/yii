<?php
namespace application\components\validators;

class NestedFormValidator extends \CValidator
{
    public $when;

    protected function validateAttribute($object, $attribute)
    {
        $form = $object->$attribute;
        if (!($form instanceof \CFormModel)) {
            $object->addError($attribute, \Yii::t('app', 'Неверное значение {attribute}.', ['{attribute}' => $object->getAttributeLabel($attribute)]));
            return false;
        }

        $valid = true;
        if ($this->when instanceof \Closure && !call_user_func($this->when, $form)) {
            return $valid;
        }

        if (!$form->validate()) {
            foreach ($form->getErrors() as $errors) {
                $object->addError($attribute, $errors[0]);
            }
            $valid = false;
        }
        return $valid;
    }
}