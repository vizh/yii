<?php
namespace application\components\attribute;

class IntegerDefinition extends Definition
{
    /**
     * @return array
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules[] = [$this->name, 'numerical', 'integerOnly' => true];
        return $rules;
    }

    /**
     * @param mixed $value
     * @return mixed
     */
    public function typecast($value)
    {
        return (integer) $value;
    }
}