<?php
namespace event\models;

use application\components\ActiveRecord;
use mail\components\mailers\SESMailer;
use user\models\User;

/**
 * @property int $Id
 * @property int $EventId
 * @property int $OwnerUserId
 * @property int $SenderUserId
 * @property string $CreationTime
 * @property int $Approved
 * @property int $ApprovedTime
 *
 * @property User $Sender
 * @property User $Owner
 *
 * Описание вспомогательных методов
 * @method InviteRequest   with($condition = '')
 * @method InviteRequest   find($condition = '', $params = [])
 * @method InviteRequest   findByPk($pk, $condition = '', $params = [])
 * @method InviteRequest   findByAttributes($attributes, $condition = '', $params = [])
 * @method InviteRequest[] findAll($condition = '', $params = [])
 * @method InviteRequest[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method InviteRequest byId(int $id, bool $useAnd = true)
 * @method InviteRequest byEventId(int $id, bool $useAnd = true)
 * @method InviteRequest byOwnerUserId(int $id, bool $useAnd = true)
 * @method InviteRequest bySenderUserId(int $id, bool $useAnd = true)
 * @method InviteRequest byApproved(bool $approved = true, bool $useAnd = true)
 */
class InviteRequest extends ActiveRecord
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
        return 'EventInviteRequest';
    }

    public function relations()
    {
        return [
            'Sender' => [self::BELONGS_TO, '\user\models\User', 'SenderUserId'],
            'Owner' => [self::BELONGS_TO, '\user\models\User', 'OwnerUserId'],
            'Event' => [self::BELONGS_TO, '\event\models\Event', 'EventId']
        ];
    }

    /**
     *
     * @param \event\models\Approved $status
     * @param \event\models\Role $role
     * @throws \Exception
     */
    public function changeStatus($status, \event\models\Role $role = null)
    {
        if ($status == \event\models\Approved::YES && $role == null) {
            throw new \Exception("Не передан обязательный параметр Role");
        }

        $this->Approved = $status;
        $this->ApprovedTime = date('Y-m-d H:i:s');
        $this->save();

        if ($status == \event\models\Approved::YES) {
            if (empty($this->Event->Parts)) {
                $this->Event->registerUser($this->Owner, $role, true);
            } else {
                $this->Event->registerUserOnAllParts($this->Owner, $role, true);
            }
        } elseif ($status == \event\models\Approved::NO) {
            $event = new \CModelEvent($this, ['event' => $this->Event, 'user' => $this->Owner]);
            $this->onDisapprove($event);
        }
    }

    /**
     * @return bool
     */
    protected function beforeSave()
    {
        if ($this->getIsNewRecord()) {
            $event = new \CModelEvent($this, ['event' => $this->Event, 'user' => $this->Owner]);
            $this->onCreate($event);
        }

        return parent::beforeSave();
    }

    /**
     * @param $event
     */
    public function onCreate($event)
    {
        $mailer = new SESMailer();
        $class = \Yii::getExistClass('\event\components\handlers\invite\create', ucfirst($event->params['event']->IdName), 'Base');
        /** @var \mail\components\Mail $mail */
        $mail = new $class($mailer, $event);
        $mail->send();
    }

    /**
     * @param \CModelEvent $event
     */
    public function onDisapprove($event)
    {
        $mailer = new SESMailer();
        $class = \Yii::getExistClass('\event\components\handlers\invite\disapprove', ucfirst($event->params['event']->IdName), 'Base');
        /** @var \mail\components\Mail $mail */
        $mail = new $class($mailer, $event);
        $mail->send();
    }
}
