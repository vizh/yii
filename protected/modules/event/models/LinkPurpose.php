<?php
namespace event\models;

use application\components\ActiveRecord;

/**
 * @property int $Id
 * @property int $EventId
 * @property int $PurposeId
 * @property Purpose $Purpose
 * @property Event $Event
 *
 * Описание вспомогательных методов
 * @method LinkPurpose   with($condition = '')
 * @method LinkPurpose   find($condition = '', $params = [])
 * @method LinkPurpose   findByPk($pk, $condition = '', $params = [])
 * @method LinkPurpose   findByAttributes($attributes, $condition = '', $params = [])
 * @method LinkPurpose[] findAll($condition = '', $params = [])
 * @method LinkPurpose[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method LinkPurpose byId(int $id, bool $useAnd = true)
 * @method LinkPurpose byEventId(int $id, bool $useAnd = true)
 * @method LinkPurpose byPurposeId(int $id, bool $useAnd = true)
 */
class LinkPurpose extends ActiveRecord
{
    /**
     * @param string $className
     * @return LinkPurpose
     */
    public static function model($className = __CLASS__)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::model($className);
    }

    public function tableName()
    {
        return 'EventLinkPurpose';
    }

    public function relations()
    {
        return [
            'Purpose' => [self::BELONGS_TO, '\event\models\Purpose', 'PurposeId'],
            'Event' => [self::BELONGS_TO, '\event\models\Event', 'EventId']
        ];
    }
}