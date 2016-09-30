<?php

namespace ruvents2\components\data;

use CActiveRecord;

class CDbCriteria extends \CDbCriteria
{
    public static function create()
    {
        return new static();
    }

    public function setSelect($column)
    {
        $this->select = $column;

        return $this;
    }

    public function setOrder($order)
    {
        $this->order = $order;

        return $this;
    }

    public function setLimit($limit)
    {
        $this->limit = $limit;

        return $this;
    }

    public function setWith(array $with)
    {
        $this->with = $with;

        return $this;
    }

    public function mergeWith($criteria, $operator = 'AND')
    {
        parent::mergeWith($criteria, $operator);

        return $this;
    }

    public function addConditionWithParams($condition, array $params = null, $operator = 'AND')
    {
        /* Добавляем условие обычным способом */
        parent::addCondition($condition, $operator);

        /* Добавляем необходимые параметры */
        $this->params = array_merge($this->params, $params);

        return $this;
    }

    public function apply(CActiveRecord $model)
    {
        $model->getDbCriteria()->mergeWith($this);
    }
}