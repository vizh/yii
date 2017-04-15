<?php
namespace event\models;

use application\components\ActiveRecord;
use application\components\CDbCriteria;
use application\hacks\AbstractHack;
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
 * @property int $BadgeUID уникальный идентификатор UID для RFID-бейджа
 * @property string $CreationTime
 * @property string $UpdateTime
 *
 * @property User $User
 * @property Role $Role
 * @property Event $Event
 * @property Part $Part
 *
 * Описание вспомогательных методов
 * @method Participant   with($condition = '')
 * @method Participant   find($condition = '', $params = [])
 * @method Participant   findByPk($pk, $condition = '', $params = [])
 * @method Participant   findByAttributes($attributes, $condition = '', $params = [])
 * @method Participant[] findAll($condition = '', $params = [])
 * @method Participant[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method Participant byId(int $id, $useAnd = true)
 * @method Participant byEventId(int $id, $useAnd = true)
 * @method Participant byUserId(int $id, $useAnd = true)
 * @method Participant byRoleId(int $id, $useAnd = true)
 * @method Participant byBadgeUID(int $uid, $useAnd = true)
 */
class Participant extends ActiveRecord
{
    /**
     * @var int
     */
    public $CountForCriteria;

    private $hashSalt = 'aHQR/agr(pSEt/t.EFS.BT/!';

    /**
     * @param null|string $className
     * @return static
     */
    public static function model($className = __CLASS__)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::model($className);
    }

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

    protected function afterSave()
    {
        AbstractHack::getByEvent($this->Event)->onParticipantSaved($this);
        parent::afterSave();
    }

    /**
     * @param string $idName
     * @param bool $useAnd
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
     *
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

    public function byAttributeLike($name, $value)
    {
        $this->getDbCriteria()->mergeWith(
            CDbCriteria::create()->addCondition('"Data"."Attributes"->>\''.$name.'\' ilike \'%'.$value.'%\'')
        );
    }

    public function bySearchString($search)
    {
        $users = User::model()->bySearch($search)->findAll();
        $ids = \CHtml::listData($users, 'Id', 'Id');

        $criteria = new \CDbCriteria();
        $criteria->addInCondition('"t"."UserId"', $ids);
        $criteria->mergeWith(
            CDbCriteria::create()
                ->addCondition('"Data"."Attributes"->>\'firstName\' ilike \'%'.$search.'%\'', null, 'or')
                ->addCondition('"Data"."Attributes"->>\'lastName\' ilike \'%'.$search.'%\'', null, 'or')
                ->addCondition('"Data"."Attributes"->>\'middleName\' ilike \'%'.$search.'%\'', null, 'or')
                ->addCondition('"Data"."Attributes"->>\'company\' ilike \'%'.$search.'%\'', null, 'or'),
            'or'
        );

        $this->getDbCriteria()->mergeWith($criteria);
    }

    public function byAttribute($name, $value)
    {
        $this->getDbCriteria()->mergeWith(
            CDbCriteria::create()->addCondition('"Data"."Attributes"->>\''.$name.'\' == \''.$value.'\'')
        );
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
        return substr(md5($this->EventId.$this->hashSalt.$this->UserId), 2, 25);
    }

    /**
     * Ссылка на билет
     *
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
     *
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
