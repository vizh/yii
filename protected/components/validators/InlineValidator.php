<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 07.12.2015
 * Time: 18:51
 */

namespace application\components\validators;

class InlineValidator extends \CInlineValidator
{
    /**
     * @inheritDoc
     */
    protected function validateAttribute($object, $attribute)
    {
        $method = $this->method;
        if (is_array($method)) {
            $this->params[0] = $attribute;
            return call_user_func_array($method, $this->params);
        } elseif ($method instanceof \Closure) {
            call_user_func($method, $object, $attribute, $this->params);
        } else {
            $object->$method($attribute, $this->params);
        }
    }

}