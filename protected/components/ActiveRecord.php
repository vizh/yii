<?php
namespace application\components;

use application\components\traits\ClassNameTrait;

class ActiveRecord extends \CActiveRecord
{
    use ClassNameTrait;

    /**
     * Не использовать физическое удаление записей, а проставлять Delete = true
     * @var bool
     */
    protected $useSoftDelete = false;

    /**
     * Параметры сортировки по умолчанию
     * @var array
     */
    protected $defaultOrderBy = ['"t"."Id"' => SORT_ASC];

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
                        if (is_array($value)) {
                            $criteria->addInCondition('"t"."' . $column . '"', $value);
                        } else {
                            $criteria->addCondition('"t"."' . $column . '" = :'.$column);
                            $criteria->params[$column] = $value;
                        }
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

    /**
     * Отсортировать записи, используя сортировку по умолчанию
     * @see [$this->defaultOrderBy]
     * @return ActiveRecord
     */
    public function ordered()
    {
        return $this->orderBy($this->defaultOrderBy);
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
     * Находит одну запись по PrimaryKey
     * @param $pk
     * @return array|\CActiveRecord|mixed|null
     */
    public static function findOne($pk)
    {
        return static::model()->findByPk($pk);
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

    /**
     * Создает новую модель
     * @param array $attributes
     * @return mixed
     */
    public static function insertOne($attributes = [])
    {
        $model = new static();
        $model->setAttributes($attributes, false);
        return $model->save();
    }
}