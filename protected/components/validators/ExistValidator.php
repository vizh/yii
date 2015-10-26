<?php

namespace application\components\validators;

class ExistValidator extends \CExistValidator
{
    /**
     * @inheritdoc
     */
    protected function validateAttribute($object, $attribute)
    {
        $value=$object->$attribute;
        if($this->allowEmpty && $this->isEmpty($value))
            return;

        if (!is_array($value)) {
            $value = [$value];
        }

        foreach ($value as $val) {
            $className = $this->className === null ? get_class($object) : \Yii::import($this->className);
            $attributeName = $this->attributeName === null ? $attribute : $this->attributeName;
            $finder = \CActiveRecord::model($className);
            $table = $finder->getTableSchema();
            if (($column = $table->getColumn($attributeName)) === null)
                throw new \CException(\Yii::t('yii', 'Table "{table}" does not have a column named "{column}".',
                    array('{column}' => $attributeName, '{table}' => $table->name)));

            $columnName = $column->rawName;
            $criteria = new \CDbCriteria();
            if ($this->criteria !== array())
                $criteria->mergeWith($this->criteria);
            $tableAlias = empty($criteria->alias) ? $finder->getTableAlias(true) : $criteria->alias;
            $valueParamName = \CDbCriteria::PARAM_PREFIX . \CDbCriteria::$paramCount++;
            $criteria->addCondition($this->caseSensitive ? "{$tableAlias}.{$columnName}={$valueParamName}" : "LOWER({$tableAlias}.{$columnName})=LOWER({$valueParamName})");
            $criteria->params[$valueParamName] = $val;

            if (!$finder->exists($criteria)) {
                $message = $this->message !== null ? $this->message : \Yii::t('yii', '{attribute} "{value}" is invalid.');
                $this->addError($object, $attribute, $message, array('{value}' => \CHtml::encode($val)));
            }
        }
    }

}

