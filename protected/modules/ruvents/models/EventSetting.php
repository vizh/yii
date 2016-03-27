<?php
namespace ruvents\models;

/**
 * @property int EventSettingId
 * @property int EventId
 * @property string Name
 * @property string DataBuilder
 */
class EventSetting extends \CActiveRecord
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'Mod_RuventsEventSetting';
    }

    public function primaryKey()
    {
        return 'EventSettingId';
    }

    public function byEventId($eventId, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = 't.EventId = :EventId';
        $criteria->params = [':EventId' => $eventId];
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);

        return $this;
    }
}