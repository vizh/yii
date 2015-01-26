<?php
namespace event\models;

/**
 * @property int $Id
 * @property int $EventId
 * @property string $Title
 * @property int $Order
 * @property Event $Event
 *
 * @method Part find($condition='',$params=array())
 * @method Part findByPk($pk,$condition='',$params=array())
 * @method Part[] findAll($condition='',$params=array())
 */


class Part extends \CActiveRecord
{
    /**
     * @param string $className
     * @return Part
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'EventPart';
    }

    public function primaryKey()
    {
        return 'Id';
    }

    public function relations()
    {
        return array(
            'Event' => array(self::BELONGS_TO, '\event\models\Event', 'EventId'),
        );
    }

    /**
     * @param int $eventId
     * @param bool $useAnd
     *
     * @return $this
     */
    public function byEventId($eventId, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"EventId" = :EventId';
        $criteria->params = ['EventId' => $eventId];
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }

    /**
     * @param int $eventId
     * @return int
     * @throws \CDbException
     */
    public function getMaxOrder($eventId)
    {
        $command = $this->getDbConnection()->createCommand()
            ->select('max("Order") MaxOrder')->from($this->tableName())
            ->where('"EventId" = :EventId', ['EventId' => $eventId]);
        return (int)$command->queryScalar();
    }
}