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
 * Описание вспомогательных методов
 * @method Part   with($condition = '')
 * @method Part   find($condition = '', $params = [])
 * @method Part   findByPk($pk, $condition = '', $params = [])
 * @method Part   findByAttributes($attributes, $condition = '', $params = [])
 * @method Part[] findAll($condition = '', $params = [])
 * @method Part[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method Part byId(int $id, bool $useAnd = true)
 * @method Part byEventId(int $id, bool $useAnd = true)
 */
class Part extends ActiveRecord implements JsonSerializable
{
    /**
     * @param null|string $className
     * @return static
     */
    public static function model($className = __CLASS__)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::model($className);
    }

    public function tableName()
    {
        return 'EventPart';
    }

    public function relations()
    {
        return [
            'Event' => [self::BELONGS_TO, '\event\models\Event', 'EventId'],
        ];
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