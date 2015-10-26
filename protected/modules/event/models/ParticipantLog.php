<?php
namespace event\models;

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
 * @property \user\models\User $User
 * @property Role $Role
 * @property Event $Event
 * @property Part $Part
 * @property \user\models\User $Editor
 *
 * @method \event\models\Participant find()
 * @method \event\models\Participant[] findAll()
 * @method \event\models\Participant findByPk()
 */
class ParticipantLog extends \CActiveRecord
{
    /**
     * @param string $className
     * @return Participant
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'EventParticipantLog';
    }

    public function primaryKey()
    {
        return 'Id';
    }

    public function relations()
    {
        return array(
            'Event' => array(self::BELONGS_TO, '\event\models\Event', 'EventId'),
            'Role' => array(self::BELONGS_TO, '\event\models\Role', 'RoleId'),
            'User' => array(self::BELONGS_TO, '\user\models\User', 'UserId'),
            'Editor' => array(self::BELONGS_TO, '\user\models\User', 'EditorId'),
            'Part' => array(self::BELONGS_TO, '\event\models\Part', 'PartId')
        );
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