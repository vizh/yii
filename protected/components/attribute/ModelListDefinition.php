<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 07.10.14
 * Time: 14:14
 */

namespace application\components\attribute;


class ModelListDefinition extends Definition
{
    public $className;

    public $attributeName = 'Id';

    public $valueAttributeName;

    /**
     * @param $container
     * @return string
     */
    public function getPrintValue($container)
    {
        $values = [];
        foreach ($container->{$this->name} as  $originalValue) {
            $finder = \CActiveRecord::model($this->className);
            if ($this->attributeName instanceof \Closure) {
                $method = $this->attributeName;
                $model = $method($finder, $originalValue);
            } else {
                $model = $finder->find('"t"."'.$this->attributeName.'" = :value', ['value' => $originalValue]);
            }

            if ($model == null)
                continue;

            if ($this->valueAttributeName instanceof \Closure) {
                $method = $this->valueAttributeName;
                $value = $method($model);
            } else {
                $value = $model->{$this->valueAttributeName};
            }

            if (!empty($value)) {
                $values[] = $value;
            }
        }
        return implode('<br/>',$values);
    }
} 