<?php
namespace application\components\attribute;

class IntegerDefinition extends Definition
{

    /**
     * @param mixed $value
     * @return mixed
     */
    public function typecast($value)
    {
        return (integer) $value;
    }
}