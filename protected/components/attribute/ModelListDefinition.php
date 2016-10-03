<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 07.10.14
 * Time: 14:14
 */

namespace application\components\attribute;

use application\components\AbstractDefinition;
use CActiveRecord;
use event\components\UserDataManager;

class ModelListDefinition extends AbstractDefinition
{
    public $className;

    public $attributeName = 'Id';

    public $valueAttributeName;

    /**
     * @param $manager
     * @return string
     */
    public function getPrintValue(UserDataManager $manager, $useHtml = false)
    {
        $values = [];
        foreach ($manager->{$this->name} as $originalValue) {
            $finder = CActiveRecord::model($this->className);
            if ($this->attributeName instanceof \Closure) {
                $method = $this->attributeName;
                $model = $method($finder, $originalValue);
            } else {
                $model = $finder->find('"t"."'.$this->attributeName.'" = :value', ['value' => $originalValue]);
            }

            if ($model === null) {
                continue;
            }

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

        return implode('<br>', $values);
    }
}