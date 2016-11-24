<?php

namespace application\components;

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

    /**
     * @param string $order
     * @return $this
     */
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

    public function setOffset($offset)
    {
        $this->offset = $offset;

        return $this;
    }

    public function setWith(array $with, $condition = null, array $params = null)
    {
        $this->with = $with;

        if ($condition !== null) {
            $this->condition = $condition;
            if ($params !== null) {
                $this->addParams($params);
            }
        }

        return $this;
    }

    public function setParams(array $params)
    {
        $this->params = $params;

        return $this;
    }

    public function addParams(array $params)
    {
        $this->params = array_merge($this->params, $params);

        return $this;
    }

    public function mergeWith($criteria, $operator = 'AND')
    {
        parent::mergeWith($criteria, $operator);

        return $this;
    }

    public function addCondition($condition, array $params = null, $operator = 'AND')
    {
        // Добавляем условие обычным способом
        parent::addCondition($condition, $operator);

        // Добавляем необходимые параметры
        if ($params !== null) {
            $this->params = array_merge($this->params, $params);
        }

        return $this;
    }

    public function apply(\CActiveRecord $model)
    {
        $model->getDbCriteria()->mergeWith($this);

        return $this;
    }
}