<?php
namespace link\models;

use application\components\ActiveRecord;
use event\models\Event;
use mail\components\mailers\SESMailer;
use user\models\User;
use Yii;

/**
 * @property int $Id
 * @property int $EventId
 * @property int $UserId
 * @property int $OwnerId
 * @property int $Approved
 * @property string $CreationTime
 * @property string $MeetingTime
 *
 * @property User $User
 * @property User $Owner
 * @property Event $Event
 *
 * Описание вспомогательных методов
 * @method Link   with($condition = '')
 * @method Link   find($condition = '', $params = [])
 * @method Link   findByPk($pk, $condition = '', $params = [])
 * @method Link   findByAttributes($attributes, $condition = '', $params = [])
 * @method Link[] findAll($condition = '', $params = [])
 * @method Link[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method Link byId(int $id, bool $useAnd = true)
 * @method Link byEventId(int $id, bool $useAnd = true)
 * @method Link byUserId(int $id, bool $useAnd = true)
 * @method Link byOwnerId(int $id, bool $useAnd = true)
 * @method Link byApproved(int $approved, bool $useAnd = true)
 */
class Link extends ActiveRecord
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
        return 'Link';
    }

    public function relations()
    {
        return [
            'User' => [self::BELONGS_TO, '\user\models\User', 'UserId'],
            'Owner' => [self::BELONGS_TO, '\user\models\User', 'OwnerId'],
            'Event' => [self::BELONGS_TO, '\event\models\Event', 'EventId']
        ];
    }

    /**
     * @param int $userId
     * @param bool $useAnd
     * @return $this
     */
    public function byAnyUserId($userId, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."UserId" = :UserId OR "t"."OwnerId" = :UserId';
        $criteria->params = ['UserId' => $userId];
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);

        return $this;
    }

    public function getFormattedMeetingTime($pattern = 'dd MMMM yyyy')
    {
        return Yii::app()->dateFormatter->format($pattern, $this->MeetingTime);
    }

    protected $beforeSaveIsNewRecord = null;
    protected $beforeSaveMeetingTime = null;
    protected $beforeSaveApproved = null;

    protected function beforeSave()
    {
        $this->beforeSaveIsNewRecord = $this->getIsNewRecord();
        if (!$this->beforeSaveIsNewRecord) {
            $link = $this->findByPk($this->Id);
            /** @var  Link $link */
            $this->beforeSaveMeetingTime = $link->MeetingTime;
            $this->beforeSaveApproved = $link->Approved;
        }

        return parent::beforeSave();
    }

    protected function afterSave()
    {
        $eventType = null;
        if ($this->beforeSaveIsNewRecord) {
            $eventType = 'create';
        } elseif ($this->beforeSaveApproved != \event\models\Approved::YES && $this->Approved == \event\models\Approved::YES) {
            $eventType = 'approve';
        } elseif ($this->beforeSaveMeetingTime !== null && $this->beforeSaveMeetingTime !== $this->MeetingTime) {
            $eventType = 'changetime';
        }

        if ($eventType !== null) {
            $event = new \CModelEvent($this);
            $mailer = new SESMailer();
            $sender = $event->sender;
            $class = Yii::getExistClass('\link\components\handlers\\'.$eventType, ucfirst($sender->Event->IdName), 'Base');
            /** @var \mail\components\Mail $mail */
            $mail = new $class($mailer, $event);
            $mail->send();
        }
        parent::afterSave();
    }
}
