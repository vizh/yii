<?php
namespace event\models;

use application\components\ActiveRecord;
use event\components\tickets\Ticket;
use mail\components\mailers\SESMailer;
use partner\models\Account;
use user\models\User;

/**
 * @property int $Id
 * @property int $EventId
 * @property int $PartId
 * @property int $UserId
 * @property int $RoleId
 * @property string $CreationTime
 * @property string $UpdateTime
 *
 * @property User $User
 * @property Role $Role
 * @property Event $Event
 * @property Part $Part
 *
 * @method Participant find()
 * @method Participant[] findAll($criteria)
 * @method Participant findByPk()
 */
class Participant extends ActiveRecord
{
    /**
     * @var int
     */
    public $CountForCriteria;

    private $hashSalt = 'aHQR/agr(pSEt/t.EFS.BT/!';

    /**
     * @inheritdoc
     */
    public function tableName()
    {
        return 'EventParticipant';
    }

    /**
     * @inheritdoc
     */
    public function relations()
    {
        return [
            'Event' => [self::BELONGS_TO, 'event\models\Event', 'EventId'],
            'Role' => [self::BELONGS_TO, 'event\models\Role', 'RoleId'],
            'User' => [self::BELONGS_TO, 'user\models\User', 'UserId'],
            'Part' => [self::BELONGS_TO, 'event\models\Part', 'PartId'],
            'Data' => [self::HAS_MANY, 'event\models\UserData', ['UserId' => 'UserId'], 'on' => '"Data"."EventId" = "t"."EventId"']
        ];
    }

    /**
     * @param int $userId
     * @param bool $useAnd
     * @return Participant
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
     * @return Participant
     */
    public function byEventId($eventId, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."EventId" = :EventId';
        $criteria->params = [':EventId' => $eventId];
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);

        return $this;
    }

    /**
     * @param string  $idName
     * @param bool    $useAnd
     * @return Participant
     */
    public function byEventIdName($idName, $useAnd = true)
    {
        $this->getDbCriteria()->mergeWith([
            'with' => 'Event',
            'condition' => '"Event"."IdName" = :idName',
            'params' => [':idName' => $idName]
        ], $useAnd);

        return $this;
    }

    /**
     * Adds condition
     * @param string $email Email for the search
     * @param bool $useAnd
     * @return self
     */
    public function byParticipantEmail($email, $useAnd = true)
    {
        $this->getDbCriteria()->mergeWith([
            'with' => 'User',
            'condition' => '"User"."Email" = :email',
            'params' => [':email' => $email]
        ], $useAnd);

        return $this;
    }

    /**
     * @param int $roleId
     * @param bool $useAnd
     *
     * @return Participant
     */
    public function byRoleId($roleId, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."RoleId" = :RoleId';
        $criteria->params = [':RoleId' => $roleId];
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);

        return $this;
    }

    /**
     * @param int|int[]|null $partId
     * @param bool $useAnd
     * @return Participant
     */
    public function byPartId($partId, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        if ($partId === null) {
            $criteria->addCondition('t."PartId" IS NULL');
        } elseif (is_array($partId)) {
            $criteria->addInCondition('t."PartId"', $partId);
        } else {
            $criteria->condition = 't."PartId" = :PartId';
            $criteria->params = ['PartId' => $partId];
        }

        $this->getDbCriteria()->mergeWith($criteria, $useAnd);

        return $this;
    }

    /**
     * @param Role $role
     * @param bool $usePriority
     * @return bool
     */
    public function UpdateRole($role, $usePriority = false)
    {
        if (!$usePriority || $this->Role->Priority <= $role->Priority) {
            $oldRole = $this->Role;

            $this->RoleId = $role->RoleId;
            $this->UpdateTime = time();
            $this->save();

            /** @var Account $partnerAccount */
            if ($partnerAccount = Account::model()->byEventId($this->EventId)->find()) {
                $partnerAccount->GetNotifier()->NotifyRoleChange($this->User, $oldRole, $role);
            }

            return true;
        }

        return false;
    }

    public function getHash()
    {
        return substr(md5($this->EventId . $this->hashSalt . $this->UserId), 2, 25);
    }

    /**
     * Ссылка на билет
     * @return string
     */
    public function getTicketUrl()
    {
        return \Yii::app()->createAbsoluteUrl('/event/ticket/index', [
            'eventIdName' => $this->Event->IdName,
            'runetId' => $this->User->RunetId,
            'hash' => $this->getHash()
        ]);
    }

    /**
     * Возвращает билет
     * @return Ticket
     */
    public function getTicket()
    {
        $class = \Yii::getExistClass('event\components\tickets', ucfirst($this->Event->IdName), 'Ticket');
        return new $class($this->Event, $this->User);
    }

    /**
     * Sends ticket to the participant
     */
    public function sendTicket()
    {
        $this->refresh();

        if (!$this->Role) {
            throw new \CException('Привет');
        }

        $mailer = new SESMailer();
        $e = new \CEvent($this->Event, [
            'user' => $this->User,
            'role' => $this->Role,
            'participant' => $this
        ]);

        $class = \Yii::getExistClass('event\components\handlers\register', ucfirst($this->Event->IdName), 'Base');
        /** @var \mail\components\Mail $mail */
        $mail = new $class($mailer, $e);
        return $mail->send();
    }
}
