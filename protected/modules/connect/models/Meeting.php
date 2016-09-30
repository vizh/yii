<?php

namespace connect\models;

use application\components\ActiveRecord;
use mail\components\mailers\SESMailer;
use user\models\User;
use Yii;

/**
 * @property integer $Id
 * @property integer $CreatorId
 * @property integer $PlaceId
 * @property string $Date
 * @property integer $Type
 * @property string $CreateTime
 * @property integer $ReservationNumber
 * @property integer $Status
 *
 * @property Place $Place
 * @property User $Creator
 * @property MeetingLinkUser[] $UserLinks
 *
 * @method Meeting byPlaceId(int $id)
 * @method Meeting byCreatorId(int $id)
 * @method Meeting byType(int $id)
 * @method Meeting byReservationNumber(int $id)
 *
 * @method Meeting with($condition='')
 * @method Meeting find($condition='',$params=array())
 * @method Meeting findByPk($pk,$condition='',$params=array())
 * @method Meeting findByAttributes($attributes,$condition='',$params=array())
 * @method Meeting[] findAll($condition='',$params=array())
 * @method Meeting[] findAllByAttributes($attributes,$condition='',$params=array())
 */
class Meeting extends ActiveRecord
{
    const TYPE_PRIVATE = 1;
    const TYPE_PUBLIC = 2;

    const STATUS_OPEN = 1;
    const STATUS_CANCELLED = 2;

    public function tableName()
    {
        return 'ConnectMeeting';
    }

    public function relations()
    {
        return [
            'Place' => [self::BELONGS_TO, '\connect\models\Place', 'PlaceId'],
            'Creator' => [self::BELONGS_TO, '\user\models\User', 'CreatorId'],
            'UserLinks' => [self::HAS_MANY, '\connect\models\MeetingLinkUser', 'MeetingId']
        ];
    }

    public function byUserId($id)
    {
        $criteria = new \CDbCriteria();
        $criteria->with[] = 'UserLinks';
        $criteria->condition = '"UserLinks"."UserId" = :id';
        $criteria->params = array('id' => $id);
        $this->getDbCriteria()->mergeWith($criteria);
        return $this;
    }

    public function getFileDir()
    {
        $dir = Yii::getPathOfAlias('webroot').'/files/connect';
        if (!is_dir($dir)){
            mkdir($dir, 0755, true);
        }
        return $dir;
    }

    public function getFileUrl($absolute = false)
    {
        if (!$this->File){
            return '';
        }
        $url = '/files/connect/'.$this->File;
        return rtrim ($absolute ? Yii::app()->createAbsoluteUrl($url) : Yii::app()->createUrl($url), '/');
    }

    public function onInvite(\CEvent $event)
    {
        /** @var self $sender */
        $sender = $event->sender;
        $sender->refresh();

        $event->params['meeting'] = $this;

        $class = Yii::getExistClass('\connect\components\handlers\invite', ucfirst($sender->Place->Event->IdName), 'Base');
        /** @var $mail \connect\components\handlers\invite\Base */
        $mail = new $class(new SESMailer(), $event);
        $mail->send();

        $this->raiseEvent('onInvite', $event);
    }

    public function onAccept(\CEvent $event)
    {
        /** @var self $sender */
        $sender = $event->sender;
        $sender->refresh();

        $event->params['meeting'] = $this;

        $class = Yii::getExistClass('\connect\components\handlers\accept', ucfirst($sender->Place->Event->IdName), 'Base');
        /** @var $mail \connect\components\handlers\accept\Base */
        $mail = new $class(new SESMailer(), $event);
        $mail->send();

        $this->raiseEvent('onAccept', $event);
    }

    public function onDecline(\CEvent $event)
    {
        /** @var self $sender */
        $sender = $event->sender;
        $sender->refresh();

        $event->params['meeting'] = $this;

        $class = Yii::getExistClass('\connect\components\handlers\decline', ucfirst($sender->Place->Event->IdName), 'Base');
        /** @var $mail \connect\components\handlers\decline\Base */
        $mail = new $class(new SESMailer(), $event);
        $mail->send();

        $this->raiseEvent('onDecline', $event);
    }
}