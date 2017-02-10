<?php
namespace event\models;

use application\components\ActiveRecord;
use user\models\User;

/**
 * @property int $Id
 * @property int $EventId
 * @property int $PartId
 * @property int $UserId
 * @property int $RoleId
 * @property string $CreationTime
 * @property string $Message
 * @property int $EditorId
 *
 * @property User $User
 * @property Role $Role
 * @property Event $Event
 * @property Part $Part
 * @property User $Editor
 *
 * Описание вспомогательных методов
 * @method ParticipantLog   with($condition = '')
 * @method ParticipantLog   find($condition = '', $params = [])
 * @method ParticipantLog   findByPk($pk, $condition = '', $params = [])
 * @method ParticipantLog   findByAttributes($attributes, $condition = '', $params = [])
 * @method ParticipantLog[] findAll($condition = '', $params = [])
 * @method ParticipantLog[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method ParticipantLog byId(int $id, bool $useAnd = true)
 * @method ParticipantLog byEventId(int $id, bool $useAnd = true)
 * @method ParticipantLog byPartId(int $id, bool $useAnd = true)
 * @method ParticipantLog byUserId(int $id, bool $useAnd = true)
 * @method ParticipantLog byRoleId(int $id, bool $useAnd = true)
 * @method ParticipantLog byEditorId(int $id, bool $useAnd = true)
 */
class ParticipantLog extends ActiveRecord
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
        return 'EventParticipantLog';
    }

    public function relations()
    {
        return [
            'Event' => [self::BELONGS_TO, '\event\models\Event', 'EventId'],
            'Role' => [self::BELONGS_TO, '\event\models\Role', 'RoleId'],
            'User' => [self::BELONGS_TO, '\user\models\User', 'UserId'],
            'Editor' => [self::BELONGS_TO, '\user\models\User', 'EditorId'],
            'Part' => [self::BELONGS_TO, '\event\models\Part', 'PartId']
        ];
    }

    /**
     * @param Participant $participant
     * @return $this
     */
    public function byParticipant(Participant $participant)
    {
        $criteria = new \CDbCriteria();
        $criteria->addCondition('"t"."UserId" = :UserId AND "t"."RoleId" = :RoleId AND "t"."EventId" = :EventId');
        $criteria->params['UserId']  = $participant->UserId;
        $criteria->params['RoleId']  = $participant->RoleId;
        $criteria->params['EventId'] = $participant->EventId;
        if (!empty($participant->PartId)) {
            $criteria->addCondition('"t"."PartId" = :PartId');
            $criteria->params['PartId'] = $participant->PartId;
        }
        $criteria->order = '"t"."CreationTime" DESC';
        $this->getDbCriteria()->mergeWith($criteria);
        return $this;
    }
}