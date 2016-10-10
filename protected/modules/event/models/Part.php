<?php
namespace event\models;
use application\components\ActiveRecord;
use JsonSerializable;

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


class Part extends ActiveRecord implements JsonSerializable
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

    /**
     * Specify data which should be serialized to JSON
     *
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return [
            'Id' => $this->Id,
            'Name' => $this->Title
        ];
    }
}