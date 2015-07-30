<?php
namespace application\components;

class ActiveRecord extends \CActiveRecord
{
    protected $useSoftDelete = false;

    public function __call($name, $parameters)
    {
        if (strpos($name, 'by') === 0) {
            $column = substr($name,2);
            $schema = $this->getTableSchema();
            if (array_key_exists($column, $schema->columns)) {
                $criteria = new \CDbCriteria();
                if ($schema->getColumn($column)->dbType !== 'boolean') {
                    $value = $parameters[0];
                    if ($value !== null) {
                        $criteria->addCondition('"t"."' . $column . '" = :'.$column);
                        $criteria->params[$column] = $value;
                    } else {
                        $criteria->addCondition('"t"."' . $column . '" IS NULL');
                    }
                } else {
                    $criteria->addCondition(($parameters[0] === false ? 'NOT ' : '') . '"t"."' . $column . '"');
                }
                $this->getDbCriteria()->mergeWith($criteria, true);
                return $this;
            }
        }
        return parent::__call($name, $parameters);
    }

    /**
     * Устанавливает сортировку
     * @param array $orders
     * @return $this
     */
    public function orderBy($orders)
    {
        if (!is_array($orders)) {
            $orders = [$orders];
        }

        $criteria = new \CDbCriteria();
        foreach ($orders as $column => $order) {
            if (!is_string($column)) {
                $column = $order;
                $order  = SORT_ASC;
            }
            $criteria->order .= (!empty($criteria->order) ? ', ' : '') . $column . ' ' . ($order === SORT_DESC ? 'DESC' : 'ASC');
        }
        $this->getDbCriteria()->mergeWith($criteria);
        return $this;
    }

    protected function afterFind()
    {
        $this->oldAttributes = $this->getAttributes();
        parent::afterFind();
    }


    /**
     * Устанавливает лимит записей
     * @param int $limit
     * @return $this
     */
    public function limit($limit)
    {
        $this->getDbCriteria()->limit = $limit;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function delete()
    {
        if ($this->useSoftDelete) {
            $this->Deleted = true;
            $this->DeletionTime = date('Y-m-d H:i:s');
            $this->save();
            return true;
        } else {
            return parent::delete();
        }
    }

    private $oldAttributes = array();

    /**
     * Устанавливает значения атрибутов до измнения модели
     * @param $value
     */
    public function setOldAttributes($value)
    {
        $this->oldAttributes = $value;
    }

    /**
     * Возвращает значение атрибутов до изменения модели
     * @return array
     */
    public function getOldAttributes()
    {
        return $this->oldAttributes;
    }
}