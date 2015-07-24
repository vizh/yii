<?php
namespace event\models;

/**
 * @property int $Id
 * @property int $EventId
 * @property string $Name
 * @property string $Value
 * @property int $Order
 *
 * @property Event $Event
 *
 * @method Attribute find()
 */
class Attribute extends \application\models\translation\ActiveRecord
{
    /**
     * @param string $className
     * @return Attribute
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'EventAttribute';
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
     *
     * @return string[]
     */
    public function getTranslationFields()
    {
        return ['Value'];
    }


    /**
     * @param int $eventId
     * @param bool $useAnd
     * @return $this
     */
    public function byEventId($eventId, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."EventId" = :EventId';
        $criteria->params = ['EventId' => $eventId];
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }

    /**
     * @param string $name
     * @param bool $useAnd
     * @return $this
     */
    public function byName($name, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."Name" = :Name';
        $criteria->params = ['Name' => $name];
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }
}
