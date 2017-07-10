<?php
namespace application\components;

use application\components\helpers\ArrayHelper;
use application\models\security\SecurityLog;
use CDbCriteria;

/**
 * Class ActiveRecord Base class for all active records
 */
abstract class ActiveRecord extends \CActiveRecord
{
    /**
     * @var bool Не использовать физическое удаление записей, а проставлять Delete = true
     */
    protected $useSoftDelete = false;

    /**
     * @var array Sort params by default
     */
    protected $defaultOrderBy = ['"t"."Id"' => SORT_ASC];

    /**
     * @var array Оригинальный набор атрибутов, какой он был на момент получения данных из базы
     */
    private $attributesBackup;

    /**
     * Returns name of the class
     *
     * @return string
     */
    public static function className()
    {
        return get_called_class();
    }

    /**
     * Returns the instance of the active record by using late static binding
     *
     * @param string $className
     * @return static
     */
    public static function model($className = null)
    {
        if ($className === null) {
            $className = get_called_class();
        }

        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::model($className);
    }

    /**
     * Атрибуты, изменения которых не журналируются
     */
    public static function untrackedAttributes()
    {
        return [];
    }

    /**
     * Creates a new one moel
     *
     * @param array $attributes
     * @return mixed
     */
    public static function insertOne($attributes = [])
    {
        $model = new static();
        $model->setAttributes($attributes, false);

        return $model->save();
    }

    /**
     * Находит одну запись по PrimaryKey
     *
     * @param mixed $pk
     * @return array|\CActiveRecord|mixed|null
     */
    public static function findOne($pk)
    {
        return static::model()->findByPk($pk);
    }

    /**
     * Copies the active record
     *
     * @param array $newAttributes The new attributes that will be assigned to the new active record. It uses following
     * format ['Attribute1' => 'value1', 'Attribute2' => 'value2']
     * @return null|static The new model
     */
    public function copy($newAttributes = [])
    {
        try {
            $new = new static();
            $new->setAttributes($this->getAttributes(), false);

            $pk = $this->getMetaData()->tableSchema->primaryKey;
            if (!is_array($pk)) {
                $new->$pk = null;
            }

            foreach ($newAttributes as $attr => $value) {
                $new->$attr = $value;
            }

            $new->save(false);

            return $new;
        } catch (\CDbException $e) {
            return null;
        }
    }

    /**
     * Magic method __call
     *
     * @param string $name
     * @param array $parameters
     * @return $this|mixed
     */
    public function __call($name, $parameters)
    {
        if (strpos($name, 'by') === 0) {
            $column = substr($name, 2);
            $schema = $this->getTableSchema();
            if (isset($schema->columns[$column]) === true) {
                $columnType = $schema->getColumn($column)->dbType;
                $criteria = new CDbCriteria();
                if ($columnType === 'boolean') {
                    $criteria->addCondition(($parameters[0] === false ? 'NOT ' : '').'"t"."'.$column.'"');
                } else {
                    $value = $parameters[0];
                    $isarr = is_array($value);
                    if ($columnType === 'integer') {
                        $value = $isarr === true
                            ? array_map('intval', $value)
                            : (int)$value;
                    } else {
                        // Данное преобразование важно, если поле для фильтрации имеет строковый тип,
                        // но значение для фильтра передано в виде числа.
                        $value = $isarr === true
                            ? array_map('strval', $value)
                            : (string)$value;
                    }
                    if ($value) {
                        if ($isarr === true) {
                            $criteria->addInCondition('"t"."'.$column.'"', $value);
                        } else {
                            $criteria->addCondition('"t"."'.$column.'" = :'.$column);
                            $criteria->params[$column] = $value;
                        }
                    } else {
                        $criteria->addCondition('"t"."'.$column.'" IS NULL');
                    }
                }
                $this->getDbCriteria()->mergeWith($criteria, true);

                return $this;
            }
        }

        if (strpos($name, 'orderBy') === 0) {
            $this->orderBy(['"t"."'.substr($name, 7).'"' => $parameters[0]]);

            return $this;
        }

        return parent::__call($name, $parameters);
    }

    /**
     * Set sort orders
     *
     * @param array $orders
     * @return $this
     */
    public function orderBy($orders)
    {
        if (!is_array($orders)) {
            $orders = [$orders];
        }

        $criteria = new CDbCriteria();
        foreach ($orders as $column => $order) {
            if (!is_string($column)) {
                $column = $order;
                $order = SORT_ASC;
            }
            $criteria->order .= (!empty($criteria->order) ? ', ' : '').$column.' '.($order === SORT_DESC ? 'DESC' : 'ASC');
        }
        $this->getDbCriteria()->mergeWith($criteria);

        return $this;
    }

    /**
     * Отсортировать записи, используя сортировку по умолчанию
     *
     * @see [$this->defaultOrderBy]
     * @return ActiveRecord
     */
    public function ordered()
    {
        return $this->orderBy($this->defaultOrderBy);
    }

    /**
     * Устанавливает лимит записей
     *
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
        }

        return parent::delete();
    }

    protected function afterFind()
    {
        $this->attributesBackup = $this->attributes;

        parent::afterFind();
    }

    protected function beforeDelete()
    {
        if (null !== $log = SecurityLog::create(SecurityLog::ACTION_DELETE)) {
            $log->Model = self::className();
            $log->Attributes = $this->attributes;
            if (false === $log->save()) {
                throw new Exception($log);
            }
        }

        return parent::beforeDelete();
    }

    protected function afterSave()
    {
        // Не журналируем изменения самих себя
        if ($this instanceof SecurityLog) {
            return;
        }

        $action = $this->getIsNewRecord()
            ? SecurityLog::ACTION_CREATE
            : SecurityLog::ACTION_UPDATE;

        // Если есть изменения, то логируем их
        if (null !== $log = SecurityLog::create($action)) {
            $log->Model = self::className();
            $log->Attributes = $this->attributesBackup;
            $log->Changes = ArrayHelper::difference($this->attributesBackup, $this->attributes, static::untrackedAttributes());
            // Сохраняем запись в журнале только если есть значимые изменения модели
            if (false === empty($log->Changes) && false === $log->save()) {
                throw new Exception($log);
            }
        }

        parent::afterSave();
    }
}
