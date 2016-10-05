<?php
namespace application\components\attribute;

use application\components\AbstractDefinition;

class IntegerDefinition extends AbstractDefinition
{
    /**
     * @return array
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [$this->name, 'numerical', 'integerOnly' => true]
        ]);
    }

    /**
     * @param mixed $value
     * @return mixed
     */
    public function typecast($value)
    {
        return (integer)$value;
    }
}