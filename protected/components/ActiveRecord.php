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
                    $criteria->addCondition('"t"."' . $column . '" = :'.$column);
                    $criteria->params[$column] = $parameters[0];
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
            $criteria->order .= $column . ' ' . ($order === SORT_DESC ? 'DESC' : 'ASC');
        }
        $this->getDbCriteria()->mergeWith($criteria);
        return $this;
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

    private static $_events = array();

    public function __set($name, $value)
    {
        if(strncasecmp($name,'on',2)===0 && method_exists($this, $name)) {
            self::$_events[] = array(
                'component' => get_class($this),
                'name' => $name,
                'handler' => $value
            );
        }

        parent::__set($name, $value);
    }


    /**
     * Attach exists events while model creation
     */
    public function init()
    {
        $this->attachEvents($this->events());
    }

    /**
     * Attach events
     *
     * @param array $events
     */
    public function attachEvents($events)
    {
        foreach ($events as $event) {
            if ($event['component'] == get_class($this))
                parent::attachEventHandler($event['name'], $event['handler']);
        }
    }

    /**
     * Get exists events
     *
     * @return array
     */
    public function events()
    {
        return self::$_events;
    }

    /**
     * Attach event handler
     *
     * @param string $name Event name
     * @param mixed $handler Event handler
     */
    public function attachEventHandler($name,$handler)
    {
        self::$_events[] = array(
            'component' => get_class($this),
            'name' => $name,
            'handler' => $handler
        );
        parent::attachEventHandler($name, $handler);
    }

    /**
     * Dettach event hander
     *
     * @param string $name Event name
     * @param mixed $handler Event handler
     * @return bool
     */
    public function detachEventHandler($name,$handler)
    {
        foreach (self::$_events as $index => $event) {
            if ($event['name'] == $name && $event['handler'] == $handler)
                unset(self::$_events[$index]);
        }
        return parent::detachEventHandler($name, $handler);
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
}