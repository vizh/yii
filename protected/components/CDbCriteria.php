<?php

namespace application\components;

class CDbCriteria extends \CDbCriteria
{
    /**
     * @return CDbCriteria
     */
    public static function create()
    {
        return new static();
    }

    /**
     * @return CDbCriteria
     */
    public function setSelect($column)
    {
        $this->select = $column;

        return $this;
    }

    /**
     * @return CDbCriteria
     */
    public function setOrder($order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * @return CDbCriteria
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * @return CDbCriteria
     */
    public function setOffset($offset)
    {
        $this->offset = $offset;

        return $this;
    }

    /**
     * @return CDbCriteria
     */
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

    /**
     * @return CDbCriteria
     */
    public function setParams(array $params)
    {
        $this->params = $params;

        return $this;
    }

    /**
     * @return CDbCriteria
     */
    public function addParams(array $params)
    {
        $this->params = array_merge($this->params, $params);

        return $this;
    }

    /**
     * @return CDbCriteria
     */
    public function mergeWith($criteria, $operator = 'AND')
    {
        parent::mergeWith($criteria, $operator);

        return $this;
    }

    /**
     * @inheritdoc
     *
     * @return CDbCriteria
     */
    public function addCondition($condition, $operator = 'AND')
    {
        // Добавляем условие обычным способом
        parent::addCondition($condition, $operator);

        return $this;
    }

    /**
     * @return CDbCriteria
     */
    public function apply(\CActiveRecord $model)
    {
        $model->getDbCriteria()->mergeWith($this);

        return $this;
    }
}