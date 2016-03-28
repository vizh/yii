<?php
namespace ruvents\models;

/**
 * @property int $Id
 * @property int $EventId
 * @property int $OperatorId
 * @property int $UserId
 * @property string $Controller
 * @property string $Action
 * @property string $Changes
 * @property string $CreationTime
 *
 * @property Operator $Operator
 */
class DetailLog extends \CActiveRecord
{
    /**
     * @static
     * @param string $className
     * @return DetailLog
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'RuventsDetailLog';
    }

    public function primaryKey()
    {
        return 'Id';
    }

    public function relations()
    {
        return [
            'Operator' => [self::BELONGS_TO, '\ruvents\models\Operator', 'OperatorId'],
            'User' => [self::BELONGS_TO, '\user\models\User', 'UserId']
        ];
    }


    /**
     * @param int $userId
     * @param bool $useAnd
     * @return DetailLog
     */
    public function byUserId($userId, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."UserId" = :UserId';
        $criteria->params = [':UserId' => $userId];
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);

        return $this;
    }

    /**
     * @param int $eventId
     * @param bool $useAnd
     * @return DetailLog
     */
    public function byEventId($eventId, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."EventId" = :EventId';
        $criteria->params = [':EventId' => $eventId];
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);

        return $this;
    }

    /** @var ChangeMessage[] */
    private $changeMessages = null;

    /**
     * @param ChangeMessage $changeMessages
     */
    public function addChangeMessage($changeMessages)
    {
        if ($this->changeMessages === null) {
            $this->changeMessages = [];
        }
        $this->changeMessages[] = $changeMessages;
    }

    public function getChangeMessages()
    {
        if ($this->changeMessages === null) {
            $this->changeMessages = unserialize(base64_decode($this->Changes));
        }

        return $this->changeMessages;
    }

    public function beforeSave()
    {
        if (parent::beforeSave() && $this->changeMessages !== null) {
            $this->Changes = base64_encode(serialize($this->changeMessages));

            return true;
        }

        return false;
    }

    /**
     * @return DetailLog
     */
    public function createBasic()
    {
        $clone = new DetailLog();
        $clone->EventId = $this->EventId;
        $clone->OperatorId = $this->OperatorId;
        $clone->UserId = $this->UserId;
        $clone->Controller = $this->Controller;
        $clone->Action = $this->Action;

        return $clone;
    }
}
